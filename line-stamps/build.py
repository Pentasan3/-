"""
クマガチ LINEスタンプ ジェネレータ

手描き風のクマガチ（クマのキャラクター）を5つのシーンで描画し、
LINEスタンプ仕様（370x320 PNG, 透過背景）で書き出します。
さらに、メイン画像（240x240）とタブ画像（96x74）も出力します。

使い方:
    python3 build.py
"""

from __future__ import annotations

import math
import os
import random
from pathlib import Path

import cairosvg

ROOT = Path(__file__).parent
SVG_DIR = ROOT / "svg"
PNG_DIR = ROOT / "png"
SVG_DIR.mkdir(exist_ok=True)
PNG_DIR.mkdir(exist_ok=True)

STAMP_W, STAMP_H = 370, 320

STROKE = "#1a1a1a"
SW = 3.2
SW_THIN = 2.0


def jitter(x: float, y: float, amt: float = 1.0, rng: random.Random | None = None) -> tuple[float, float]:
    r = rng or random
    return x + r.uniform(-amt, amt), y + r.uniform(-amt, amt)


def hand_path(points: list[tuple[float, float]], close: bool = False, jit: float = 0.6, seed: int = 0) -> str:
    rng = random.Random(seed)
    pts = [jitter(x, y, jit, rng) for x, y in points]
    d = f"M{pts[0][0]:.1f},{pts[0][1]:.1f}"
    for i in range(1, len(pts)):
        x0, y0 = pts[i - 1]
        x1, y1 = pts[i]
        cx, cy = (x0 + x1) / 2 + rng.uniform(-1, 1), (y0 + y1) / 2 + rng.uniform(-1, 1)
        d += f" Q{cx:.1f},{cy:.1f} {x1:.1f},{y1:.1f}"
    if close:
        d += " Z"
    return d


def hand_circle(cx: float, cy: float, r: float, seed: int = 0, jit: float = 0.8) -> str:
    rng = random.Random(seed)
    pts = []
    n = 24
    for i in range(n + 1):
        a = (i / n) * math.tau
        rr = r + rng.uniform(-jit, jit)
        pts.append((cx + math.cos(a) * rr, cy + math.sin(a) * rr))
    return hand_path(pts, close=True, jit=0.3, seed=seed + 1)


def hand_rect(x: float, y: float, w: float, h: float, seed: int = 0) -> str:
    pts = [(x, y), (x + w, y), (x + w, y + h), (x, y + h)]
    return hand_path(pts, close=True, jit=0.7, seed=seed)


def hand_line(x1: float, y1: float, x2: float, y2: float, seed: int = 0, jit: float = 0.6) -> str:
    rng = random.Random(seed)
    n = max(2, int(math.hypot(x2 - x1, y2 - y1) / 12))
    pts = []
    for i in range(n + 1):
        t = i / n
        x = x1 + (x2 - x1) * t + rng.uniform(-jit, jit)
        y = y1 + (y2 - y1) * t + rng.uniform(-jit, jit)
        pts.append((x, y))
    return hand_path(pts, close=False, jit=0.2, seed=seed + 1)


def fur_dots(cx: float, cy: float, w: float, h: float, count: int = 30, seed: int = 0) -> str:
    rng = random.Random(seed)
    out = []
    for i in range(count):
        x = cx + rng.uniform(-w / 2, w / 2)
        y = cy + rng.uniform(-h / 2, h / 2)
        a = rng.uniform(-0.6, 0.6)
        dx = math.cos(a) * 4
        dy = math.sin(a) * 4 + 2
        out.append(
            f'<path d="M{x:.1f},{y:.1f} l{dx:.1f},{dy:.1f}" '
            f'stroke="{STROKE}" stroke-width="{SW_THIN}" stroke-linecap="round" fill="none"/>'
        )
    return "\n".join(out)


def kumagachi(cx: float, cy: float, scale: float = 1.0, arms: str = "up", seed: int = 42) -> str:
    """Draw the Kumagachi bear character. arms: 'up' or 'side'."""
    s = scale
    parts: list[str] = []

    # Body (rounded trapezoid)
    body_top_y = cy + 30 * s
    body_bot_y = cy + 130 * s
    body_w_top = 80 * s
    body_w_bot = 95 * s
    body_pts = [
        (cx - body_w_top, body_top_y),
        (cx + body_w_top, body_top_y),
        (cx + body_w_bot, body_bot_y),
        (cx - body_w_bot, body_bot_y),
    ]
    parts.append(
        f'<path d="{hand_path(body_pts, close=True, jit=0.8, seed=seed)}" '
        f'fill="white" stroke="{STROKE}" stroke-width="{SW}" stroke-linejoin="round"/>'
    )

    # Crotch line ^ at bottom
    parts.append(
        f'<path d="M{cx - 8 * s:.1f},{body_bot_y - 2:.1f} L{cx:.1f},{body_bot_y - 12 * s:.1f} L{cx + 8 * s:.1f},{body_bot_y - 2:.1f}" '
        f'fill="none" stroke="{STROKE}" stroke-width="{SW_THIN}" stroke-linecap="round" stroke-linejoin="round"/>'
    )

    # Ears
    parts.append(
        f'<path d="{hand_circle(cx - 55 * s, cy - 35 * s, 18 * s, seed=seed + 1)}" '
        f'fill="white" stroke="{STROKE}" stroke-width="{SW}"/>'
    )
    parts.append(
        f'<path d="{hand_circle(cx + 55 * s, cy - 35 * s, 18 * s, seed=seed + 2)}" '
        f'fill="white" stroke="{STROKE}" stroke-width="{SW}"/>'
    )

    # Head
    parts.append(
        f'<path d="{hand_circle(cx, cy, 70 * s, seed=seed + 3, jit=1.2)}" '
        f'fill="white" stroke="{STROKE}" stroke-width="{SW}"/>'
    )

    # Eyes (large round, with pupil dot)
    eye_y = cy - 8 * s
    for i, ex in enumerate((cx - 22 * s, cx + 22 * s)):
        parts.append(
            f'<path d="{hand_circle(ex, eye_y, 14 * s, seed=seed + 10 + i)}" '
            f'fill="white" stroke="{STROKE}" stroke-width="{SW}"/>'
        )
        parts.append(
            f'<circle cx="{ex:.1f}" cy="{eye_y:.1f}" r="{3.2 * s:.1f}" fill="{STROKE}"/>'
        )

    # Nose (small dot/triangle)
    parts.append(
        f'<circle cx="{cx:.1f}" cy="{cy + 14 * s:.1f}" r="{2.2 * s:.1f}" fill="{STROKE}"/>'
    )

    # Smile mouth
    mouth = f"M{cx - 18 * s:.1f},{cy + 22 * s:.1f} Q{cx:.1f},{cy + 38 * s:.1f} {cx + 18 * s:.1f},{cy + 22 * s:.1f}"
    parts.append(
        f'<path d="{mouth}" fill="none" stroke="{STROKE}" stroke-width="{SW}" stroke-linecap="round"/>'
    )

    # Cheek tick marks
    for i, (px, py) in enumerate(((cx - 45 * s, cy + 15 * s), (cx + 42 * s, cy + 15 * s))):
        parts.append(
            f'<path d="M{px:.1f},{py:.1f} l{4 * s:.1f},{2 * s:.1f}" '
            f'stroke="{STROKE}" stroke-width="{SW_THIN}" stroke-linecap="round"/>'
        )
        parts.append(
            f'<path d="M{px:.1f},{py + 5 * s:.1f} l{4 * s:.1f},{2 * s:.1f}" '
            f'stroke="{STROKE}" stroke-width="{SW_THIN}" stroke-linecap="round"/>'
        )

    # Arms
    if arms == "up":
        # Left arm up-left
        la = [(cx - 70 * s, cy + 40 * s), (cx - 110 * s, cy - 10 * s), (cx - 130 * s, cy - 60 * s)]
        ra = [(cx + 70 * s, cy + 40 * s), (cx + 110 * s, cy - 10 * s), (cx + 130 * s, cy - 60 * s)]
        for i, arm_pts in enumerate((la, ra)):
            # Outer outline
            outer = [
                (arm_pts[0][0], arm_pts[0][1] + 12 * s),
                (arm_pts[1][0] - (12 * s if i == 0 else -12 * s), arm_pts[1][1] + 8 * s),
                (arm_pts[2][0] - (10 * s if i == 0 else -10 * s), arm_pts[2][1] + 12 * s),
                (arm_pts[2][0] + (10 * s if i == 0 else -10 * s), arm_pts[2][1] - 12 * s),
                (arm_pts[1][0] + (12 * s if i == 0 else -12 * s), arm_pts[1][1] - 8 * s),
                (arm_pts[0][0], arm_pts[0][1] - 12 * s),
            ]
            parts.append(
                f'<path d="{hand_path(outer, close=True, jit=0.7, seed=seed + 20 + i)}" '
                f'fill="white" stroke="{STROKE}" stroke-width="{SW}" stroke-linejoin="round"/>'
            )
            # Hand zigzag tips
            tip_x, tip_y = arm_pts[2]
            sign = -1 if i == 0 else 1
            zig = (
                f"M{tip_x + sign * 10 * s:.1f},{tip_y - 15 * s:.1f} "
                f"L{tip_x + sign * 18 * s:.1f},{tip_y - 8 * s:.1f} "
                f"L{tip_x + sign * 12 * s:.1f},{tip_y:.1f} "
                f"L{tip_x + sign * 20 * s:.1f},{tip_y + 8 * s:.1f} "
                f"L{tip_x + sign * 10 * s:.1f},{tip_y + 15 * s:.1f}"
            )
            parts.append(
                f'<path d="{zig}" fill="none" stroke="{STROKE}" stroke-width="{SW_THIN}" stroke-linejoin="round"/>'
            )

    # Fur dots on body
    parts.append(fur_dots(cx, cy + 80 * s, 150 * s, 90 * s, count=int(36 * s), seed=seed + 50))
    # Fur dots on head
    parts.append(fur_dots(cx, cy + 5 * s, 100 * s, 60 * s, count=int(20 * s), seed=seed + 60))

    return "\n".join(parts)


def title_text(text: str, sub: str = "クマガチの") -> str:
    """Title at top of stamp."""
    return f'''
    <text x="20" y="30" font-family="'Noto Sans CJK JP', 'Yu Gothic', sans-serif" font-size="20"
          fill="{STROKE}" font-weight="700">{sub}</text>
    <text x="185" y="78" font-family="'Noto Sans CJK JP', 'Yu Gothic', sans-serif" font-size="56"
          fill="{STROKE}" font-weight="800" text-anchor="middle"
          stroke="{STROKE}" stroke-width="1.2">{text}</text>
    '''


# ---------- Scene helpers ----------

def cherry_tree(cx: float, cy: float, seed: int = 0) -> str:
    parts = []
    # trunk Y shape
    parts.append(
        f'<path d="M{cx:.1f},{cy + 30:.1f} L{cx:.1f},{cy:.1f} L{cx - 15:.1f},{cy - 20:.1f}" '
        f'fill="none" stroke="{STROKE}" stroke-width="{SW}" stroke-linecap="round" stroke-linejoin="round"/>'
    )
    parts.append(
        f'<path d="M{cx:.1f},{cy:.1f} L{cx + 15:.1f},{cy - 20:.1f}" '
        f'fill="none" stroke="{STROKE}" stroke-width="{SW}" stroke-linecap="round"/>'
    )
    # cloud canopy
    parts.append(
        f'<path d="{hand_circle(cx, cy - 40, 36, seed=seed, jit=2.5)}" '
        f'fill="white" stroke="{STROKE}" stroke-width="{SW}"/>'
    )
    # falling petals
    rng = random.Random(seed + 5)
    for _ in range(4):
        px = cx + rng.uniform(-30, 30)
        py = cy + rng.uniform(20, 50)
        parts.append(f'<circle cx="{px:.1f}" cy="{py:.1f}" r="1.5" fill="{STROKE}"/>')
    return "\n".join(parts)


def snowman(cx: float, cy: float, seed: int = 0) -> str:
    parts = []
    parts.append(f'<path d="{hand_circle(cx, cy, 22, seed=seed)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="{hand_circle(cx, cy - 30, 14, seed=seed + 1)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    # bucket hat
    parts.append(
        f'<path d="M{cx - 10:.1f},{cy - 44:.1f} L{cx - 10:.1f},{cy - 56:.1f} L{cx + 10:.1f},{cy - 56:.1f} L{cx + 10:.1f},{cy - 44:.1f} Z" '
        f'fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>'
    )
    # eyes
    parts.append(f'<circle cx="{cx - 4:.1f}" cy="{cy - 32:.1f}" r="1.6" fill="{STROKE}"/>')
    parts.append(f'<circle cx="{cx + 4:.1f}" cy="{cy - 32:.1f}" r="1.6" fill="{STROKE}"/>')
    # smile
    parts.append(f'<path d="M{cx - 4:.1f},{cy - 27:.1f} Q{cx:.1f},{cy - 24:.1f} {cx + 4:.1f},{cy - 27:.1f}" fill="none" stroke="{STROKE}" stroke-width="1.5"/>')
    return "\n".join(parts)


def stick_person(cx: float, cy: float, action: str = "cheer", seed: int = 0) -> str:
    parts = []
    # head
    parts.append(f'<path d="{hand_circle(cx, cy - 18, 7, seed=seed)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<circle cx="{cx - 2:.1f}" cy="{cy - 19:.1f}" r="1" fill="{STROKE}"/>')
    parts.append(f'<circle cx="{cx + 2:.1f}" cy="{cy - 19:.1f}" r="1" fill="{STROKE}"/>')
    parts.append(f'<path d="M{cx - 2:.1f},{cy - 15:.1f} Q{cx:.1f},{cy - 13:.1f} {cx + 2:.1f},{cy - 15:.1f}" fill="none" stroke="{STROKE}" stroke-width="1"/>')
    # body
    parts.append(f'<path d="M{cx:.1f},{cy - 11:.1f} L{cx:.1f},{cy + 8:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    # legs
    parts.append(f'<path d="M{cx:.1f},{cy + 8:.1f} L{cx - 5:.1f},{cy + 18:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M{cx:.1f},{cy + 8:.1f} L{cx + 5:.1f},{cy + 18:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    if action == "cheer":
        parts.append(f'<path d="M{cx:.1f},{cy - 8:.1f} L{cx - 9:.1f},{cy - 18:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
        parts.append(f'<path d="M{cx:.1f},{cy - 8:.1f} L{cx + 9:.1f},{cy - 18:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    elif action == "wave":
        parts.append(f'<path d="M{cx:.1f},{cy - 6:.1f} L{cx - 10:.1f},{cy + 2:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
        parts.append(f'<path d="M{cx:.1f},{cy - 6:.1f} L{cx + 10:.1f},{cy - 14:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    return "\n".join(parts)


def cat(cx: float, cy: float, seed: int = 0) -> str:
    parts = []
    parts.append(f'<path d="{hand_circle(cx, cy, 8, seed=seed)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M{cx - 6:.1f},{cy - 6:.1f} L{cx - 4:.1f},{cy - 12:.1f} L{cx - 1:.1f},{cy - 6:.1f} Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M{cx + 1:.1f},{cy - 6:.1f} L{cx + 4:.1f},{cy - 12:.1f} L{cx + 6:.1f},{cy - 6:.1f} Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<circle cx="{cx - 3:.1f}" cy="{cy - 1:.1f}" r="1" fill="{STROKE}"/>')
    parts.append(f'<circle cx="{cx + 3:.1f}" cy="{cy - 1:.1f}" r="1" fill="{STROKE}"/>')
    parts.append(f'<path d="M{cx - 2:.1f},{cy + 3:.1f} Q{cx:.1f},{cy + 5:.1f} {cx + 2:.1f},{cy + 3:.1f}" fill="none" stroke="{STROKE}" stroke-width="1"/>')
    parts.append(f'<path d="M{cx:.1f},{cy + 8:.1f} L{cx:.1f},{cy + 14:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M{cx - 6:.1f},{cy + 14:.1f} L{cx + 6:.1f},{cy + 14:.1f}" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    return "\n".join(parts)


# ---------- 5 stamps ----------

def stamp_haru() -> str:
    parts = [title_text("春")]
    parts.append(kumagachi(185, 200, scale=0.85, seed=11))
    # left cherry tree
    parts.append(cherry_tree(45, 220, seed=21))
    # right cherry tree
    parts.append(cherry_tree(330, 220, seed=22))
    # dango skewer in right hand (top-right)
    parts.append(
        f'<path d="M295,135 L325,105" stroke="{STROKE}" stroke-width="{SW_THIN}" stroke-linecap="round"/>'
    )
    for i, dy in enumerate((0, 10, 20)):
        parts.append(f'<path d="{hand_circle(305 + i * 0, 130 + i * 0 - dy, 5, seed=30 + i)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    # otoshidama-like card in left hand (お花見の招待状っぽく)
    parts.append(
        f'<path d="{hand_rect(60, 130, 28, 22, seed=33)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>'
    )
    parts.append(f'<text x="74" y="148" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="11" text-anchor="middle" fill="{STROKE}">花見</text>')
    # two small kids cheering bottom-left
    parts.append(stick_person(95, 270, action="cheer", seed=40))
    parts.append(stick_person(125, 270, action="cheer", seed=41))
    # couple bottom-right + cat
    parts.append(stick_person(265, 270, action="cheer", seed=42))
    parts.append(stick_person(305, 270, action="wave", seed=43))
    parts.append(cat(285, 280, seed=44))
    return svg_wrap(parts)


def stamp_fuyu() -> str:
    parts = [title_text("冬")]
    parts.append(kumagachi(185, 205, scale=0.85, seed=12))
    # snowflakes
    rng = random.Random(99)
    for _ in range(28):
        x = rng.uniform(15, 355)
        y = rng.uniform(30, 310)
        parts.append(f'<circle cx="{x:.1f}" cy="{y:.1f}" r="2" fill="none" stroke="{STROKE}" stroke-width="1.2"/>')
    # roasted-sweet-potato basket in left hand
    parts.append(
        f'<path d="{hand_rect(55, 130, 38, 30, seed=55)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>'
    )
    parts.append(f'<text x="74" y="152" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="9" text-anchor="middle" fill="{STROKE}">ヤキイモ</text>')
    for i in range(4):
        parts.append(f'<ellipse cx="{62 + i * 8:.1f}" cy="125" rx="3" ry="9" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    # roasted sweet potato in right hand
    parts.append(f'<path d="{hand_circle(310, 130, 12, seed=66, jit=1.5)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    rng2 = random.Random(67)
    for _ in range(6):
        px = 310 + rng2.uniform(-8, 8)
        py = 130 + rng2.uniform(-8, 8)
        parts.append(f'<circle cx="{px:.1f}" cy="{py:.1f}" r="0.9" fill="{STROKE}"/>')
    # house bottom-left
    parts.append(f'<path d="M30,275 L30,235 L55,215 L80,235 L80,275 Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}" stroke-linejoin="round"/>')
    parts.append(f'<path d="{hand_rect(38, 248, 32, 18, seed=70)}" fill="white" stroke="{STROKE}" stroke-width="1.5"/>')
    # chimney smoke
    parts.append(f'<path d="M70,225 q-3,-6 2,-10 q5,-4 0,-10" fill="none" stroke="{STROKE}" stroke-width="1.4" stroke-linecap="round"/>')
    # snowman scene bottom-right
    parts.append(snowman(330, 270, seed=80))
    parts.append(stick_person(280, 270, action="wave", seed=81))
    return svg_wrap(parts)


def stamp_oshougatsu() -> str:
    parts = [title_text("お正月")]
    parts.append(kumagachi(185, 210, scale=0.85, seed=13))
    # masu cup of sake in left hand
    parts.append(
        f'<path d="M60,110 L92,110 L88,150 L64,150 Z" fill="white" stroke="{STROKE}" stroke-width="{SW}" stroke-linejoin="round"/>'
    )
    parts.append(f'<path d="M60,110 L92,110" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    # torii gate in right
    parts.append(f'<path d="M285,90 L355,90" stroke="{STROKE}" stroke-width="{SW}" stroke-linecap="round"/>')
    parts.append(f'<path d="M290,100 L350,100" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M298,100 L298,170" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="M342,100 L342,170" stroke="{STROKE}" stroke-width="{SW}"/>')
    # mochi-tsuki on bottom-right (mortar + mallet)
    parts.append(f'<path d="M295,275 L295,255 L335,255 L335,275 Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="{hand_circle(315, 252, 10, seed=90)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M340,235 L355,220 L360,225 L345,240 Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(stick_person(280, 268, action="cheer", seed=91))
    parts.append(stick_person(345, 268, action="cheer", seed=92))
    # couple + kagami-mochi bottom-left
    parts.append(stick_person(35, 270, action="wave", seed=93))
    parts.append(stick_person(105, 270, action="wave", seed=94))
    # kagami mochi
    parts.append(f'<path d="{hand_circle(70, 260, 10, seed=95)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="{hand_circle(70, 247, 7, seed=96)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="{hand_circle(70, 240, 3, seed=97)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(cat(85, 285, seed=98))
    return svg_wrap(parts)


def stamp_nenmatsu() -> str:
    parts = [title_text("年末")]
    parts.append(kumagachi(185, 200, scale=0.85, seed=14))
    # broom in left
    parts.append(f'<path d="M55,90 L95,140" stroke="{STROKE}" stroke-width="{SW}" stroke-linecap="round"/>')
    parts.append(f'<path d="M40,75 L70,105 L60,115 L30,85 Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    for i in range(5):
        parts.append(f'<path d="M{32 + i * 4:.1f},80 L{37 + i * 4:.1f},90" stroke="{STROKE}" stroke-width="1.2"/>')
    # nenga-jou in right
    parts.append(f'<path d="{hand_rect(290, 100, 36, 26, seed=110)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<text x="308" y="118" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="11" text-anchor="middle" fill="{STROKE}">年賀</text>')
    parts.append(f'<text x="308" y="129" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="9" text-anchor="middle" fill="{STROKE}">状</text>')
    # 大掃除 person bottom-left (cleaning fridge)
    parts.append(f'<path d="{hand_rect(20, 230, 35, 50, seed=120)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M20,253 L55,253" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(stick_person(75, 280, action="wave", seed=121))
    # person sweeping bottom-middle
    parts.append(stick_person(140, 285, action="wave", seed=122))
    parts.append(f'<path d="M150,285 L170,295" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M165,290 L180,300 L175,305 L160,295 Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    # post box bottom-right
    parts.append(f'<path d="{hand_rect(295, 215, 38, 50, seed=130)}" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<text x="314" y="240" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="9" text-anchor="middle" fill="{STROKE}">〒</text>')
    parts.append(f'<path d="M295,250 L333,250" stroke="{STROKE}" stroke-width="1.2"/>')
    parts.append(stick_person(285, 285, action="wave", seed=131))
    # coins falling
    for i, (x, y) in enumerate(((280, 275), (290, 282), (275, 295))):
        parts.append(f'<circle cx="{x}" cy="{y}" r="3" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    return svg_wrap(parts)


def persimmon_tree(cx: float, cy: float, seed: int = 0) -> str:
    parts = []
    parts.append(
        f'<path d="M{cx:.1f},{cy + 30:.1f} L{cx:.1f},{cy:.1f} L{cx - 15:.1f},{cy - 20:.1f}" '
        f'fill="none" stroke="{STROKE}" stroke-width="{SW}" stroke-linecap="round" stroke-linejoin="round"/>'
    )
    parts.append(
        f'<path d="M{cx:.1f},{cy:.1f} L{cx + 15:.1f},{cy - 20:.1f}" '
        f'fill="none" stroke="{STROKE}" stroke-width="{SW}" stroke-linecap="round"/>'
    )
    parts.append(
        f'<path d="{hand_circle(cx, cy - 40, 36, seed=seed, jit=2.5)}" '
        f'fill="white" stroke="{STROKE}" stroke-width="{SW}"/>'
    )
    rng = random.Random(seed + 7)
    for _ in range(5):
        px = cx + rng.uniform(-25, 25)
        py = cy - 40 + rng.uniform(-20, 20)
        parts.append(f'<path d="{hand_circle(px, py, 4, seed=int(rng.random() * 999), jit=0.6)}" fill="white" stroke="{STROKE}" stroke-width="1.4"/>')
        parts.append(f'<path d="M{px - 2:.1f},{py - 4:.1f} l4,0" stroke="{STROKE}" stroke-width="1.2"/>')
    return "\n".join(parts)


def stamp_aki() -> str:
    parts = [title_text("秋")]
    parts.append(kumagachi(185, 200, scale=0.85, seed=16))
    # persimmon trees both sides
    parts.append(persimmon_tree(45, 220, seed=200))
    parts.append(persimmon_tree(330, 220, seed=201))
    # branch with leaves in left hand
    parts.append(f'<path d="M85,140 Q105,110 120,80" stroke="{STROKE}" stroke-width="{SW}" fill="none" stroke-linecap="round"/>')
    rng = random.Random(210)
    for i in range(6):
        t = 0.2 + i * 0.13
        bx = 85 + (120 - 85) * t + rng.uniform(-3, 3)
        by = 140 + (80 - 140) * t + rng.uniform(-3, 3)
        parts.append(f'<path d="M{bx:.1f},{by:.1f} q-6,-3 -8,3 q4,2 8,-3 z" fill="white" stroke="{STROKE}" stroke-width="1.4"/>')
    # snack pack (お菓子) in right hand
    parts.append(f'<path d="{hand_rect(290, 100, 28, 36, seed=220)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="{hand_circle(304, 118, 7, seed=221)}" fill="white" stroke="{STROKE}" stroke-width="1.5"/>')
    parts.append(f'<text x="304" y="122" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="9" text-anchor="middle" fill="{STROKE}">栗</text>')
    # person climbing ladder bottom-left
    parts.append(f'<path d="M22,290 L40,230" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(f'<path d="M32,290 L50,230" stroke="{STROKE}" stroke-width="1.4"/>')
    for i in range(4):
        parts.append(f'<path d="M{27 + i * 4:.1f},{275 - i * 12:.1f} L{37 + i * 4:.1f},{275 - i * 12:.1f}" stroke="{STROKE}" stroke-width="1.2"/>')
    parts.append(stick_person(45, 235, action="cheer", seed=230))
    # person holding harvested fruit bottom-mid-left
    parts.append(stick_person(115, 275, action="wave", seed=231))
    parts.append(f'<path d="{hand_circle(108, 270, 5, seed=232)}" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    # cat
    parts.append(cat(150, 287, seed=233))
    # couple harvesting bottom-right with basket
    parts.append(stick_person(280, 275, action="cheer", seed=234))
    parts.append(stick_person(330, 275, action="wave", seed=235))
    parts.append(f'<path d="M340,278 L360,278 L355,295 L345,295 Z" fill="white" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(f'<path d="{hand_circle(350, 275, 4, seed=236)}" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    return svg_wrap(parts)


def stamp_natsu() -> str:
    parts = [title_text("夏")]
    parts.append(kumagachi(185, 210, scale=0.85, seed=17))
    # sun top-left
    parts.append(f'<path d="{hand_circle(40, 55, 14, seed=300)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    for i in range(8):
        a = i * math.tau / 8
        x1 = 40 + math.cos(a) * 18
        y1 = 55 + math.sin(a) * 18
        x2 = 40 + math.cos(a) * 26
        y2 = 55 + math.sin(a) * 26
        parts.append(f'<path d="M{x1:.1f},{y1:.1f} L{x2:.1f},{y2:.1f}" stroke="{STROKE}" stroke-width="1.6" stroke-linecap="round"/>')
    # cloud right of title
    parts.append(f'<path d="M250,55 q-15,0 -15,12 q0,12 15,12 l60,0 q15,0 15,-12 q0,-12 -15,-12 z" fill="white" stroke="{STROKE}" stroke-width="1.6"/>')
    parts.append(f'<path d="{hand_circle(335, 60, 6, seed=301)}" fill="white" stroke="{STROKE}" stroke-width="1.4"/>')
    # ice-cream cone (double scoop) in left hand
    parts.append(f'<path d="M55,160 L75,160 L65,185 Z" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="M58,164 L72,164 M60,170 L70,170" stroke="{STROKE}" stroke-width="1"/>')
    parts.append(f'<path d="{hand_circle(65, 150, 10, seed=310)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="{hand_circle(65, 135, 8, seed=311)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    # parfait in right hand
    parts.append(f'<path d="M300,180 L320,180 L315,160 L305,160 Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="{hand_circle(310, 152, 9, seed=320)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="M310,143 L308,135 L312,135 Z" fill="white" stroke="{STROKE}" stroke-width="1.4"/>')
    # ice cream sellers bottom-left
    parts.append(stick_person(30, 280, action="cheer", seed=330))
    parts.append(stick_person(60, 280, action="cheer", seed=331))
    parts.append(f'<path d="M22,265 L28,265 L25,275 Z" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    parts.append(f'<path d="{hand_circle(25, 260, 4, seed=332)}" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    parts.append(f'<path d="M65,265 L71,265 L68,275 Z" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    parts.append(f'<path d="{hand_circle(68, 260, 4, seed=333)}" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    # cat sitting
    parts.append(cat(105, 285, seed=334))
    # suika-wari bottom-right
    parts.append(f'<path d="M260,285 L355,285" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(stick_person(275, 270, action="cheer", seed=340))
    parts.append(f'<path d="M280,260 L295,250" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(f'<path d="M290,245 L300,260" stroke="{STROKE}" stroke-width="1.6"/>')
    parts.append(f'<path d="{hand_circle(335, 280, 12, seed=341)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="M325,278 L345,278" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(f'<path d="M340,255 q4,4 8,0 q4,-4 8,0" fill="none" stroke="{STROKE}" stroke-width="1.2"/>')
    parts.append(f'<text x="335" y="248" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="9" text-anchor="middle" fill="{STROKE}">バシッ</text>')
    return svg_wrap(parts)


def stamp_tsuyu() -> str:
    parts = [title_text_wide("梅雨")]
    parts.append(kumagachi(185, 215, scale=0.85, seed=18))
    # rain lines all over
    rng = random.Random(400)
    for _ in range(40):
        x = rng.uniform(15, 355)
        y0 = rng.uniform(85, 200)
        parts.append(f'<path d="M{x:.1f},{y0:.1f} L{x - 2:.1f},{y0 + 14:.1f}" stroke="{STROKE}" stroke-width="1.2" stroke-linecap="round"/>')
    # umbrella above head
    parts.append(f'<path d="M115,135 Q185,80 255,135 Z" fill="white" stroke="{STROKE}" stroke-width="{SW}" stroke-linejoin="round"/>')
    parts.append(f'<path d="M115,135 q12,-8 22,0 q12,-8 22,0 q12,-8 22,0 q12,-8 22,0 q12,-8 22,0 q12,-8 30,0" fill="none" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(f'<path d="M185,80 L185,160" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M185,160 q-6,4 -6,10 q0,4 6,4" fill="none" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(f'<path d="M150,135 L150,108 M185,135 L185,108 M220,135 L220,108" stroke="{STROKE}" stroke-width="1"/>')
    # shopping bag in right hand
    parts.append(f'<path d="{hand_rect(285, 175, 36, 36, seed=410)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="M290,175 q8,-15 14,0 M306,175 q8,-15 14,0" fill="none" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(f'<text x="303" y="194" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="8" text-anchor="middle" fill="{STROKE}">クマガチ</text>')
    parts.append(f'<text x="303" y="204" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="8" text-anchor="middle" fill="{STROKE}">デパート</text>')
    # teruterubouzu hanging
    parts.append(f'<path d="M55,160 L55,140" stroke="{STROKE}" stroke-width="1"/>')
    parts.append(f'<path d="M40,170 q15,-18 30,0 L65,200 L45,200 Z" fill="white" stroke="{STROKE}" stroke-width="1.4"/>')
    parts.append(f'<circle cx="51" cy="170" r="1.2" fill="{STROKE}"/>')
    parts.append(f'<circle cx="59" cy="170" r="1.2" fill="{STROKE}"/>')
    parts.append(f'<path d="M52,177 q3,2 6,0" fill="none" stroke="{STROKE}" stroke-width="1"/>')
    # cafe scene bottom-left
    parts.append(stick_person(25, 285, action="wave", seed=420))
    parts.append(f'<path d="M55,275 L100,275 L100,295 L55,295 Z" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    parts.append(stick_person(70, 270, action="wave", seed=421))
    parts.append(f'<circle cx="85" cy="278" r="2.5" fill="white" stroke="{STROKE}" stroke-width="1"/>')
    # subway entrance bottom-right
    parts.append(f'<path d="M295,250 L335,250 L335,295 L295,295 Z" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    for i in range(6):
        parts.append(f'<path d="M{300 + i * 6:.1f},260 L{300 + i * 6:.1f},290" stroke="{STROKE}" stroke-width="1"/>')
    parts.append(stick_person(355, 285, action="wave", seed=430))
    return svg_wrap(parts)


def stamp_christmas() -> str:
    parts = [title_text_wide("クリスマス")]
    parts.append(kumagachi(185, 205, scale=0.85, seed=15))
    # presents in both hands
    parts.append(f'<path d="{hand_rect(55, 110, 36, 30, seed=140)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="M73,110 L73,140 M55,125 L91,125" stroke="{STROKE}" stroke-width="1.5"/>')
    parts.append(f'<path d="M68,110 q-3,-6 0,-10 q3,-4 0,-10 M78,110 q3,-6 0,-10 q-3,-4 0,-10" fill="none" stroke="{STROKE}" stroke-width="1.5"/>')

    parts.append(f'<path d="{hand_rect(285, 110, 36, 30, seed=141)}" fill="white" stroke="{STROKE}" stroke-width="{SW}"/>')
    parts.append(f'<path d="M303,110 L303,140 M285,125 L321,125" stroke="{STROKE}" stroke-width="1.5"/>')
    parts.append(f'<path d="M298,110 q-3,-6 0,-10 q3,-4 0,-10 M308,110 q3,-6 0,-10 q-3,-4 0,-10" fill="none" stroke="{STROKE}" stroke-width="1.5"/>')

    # tree bottom-left
    parts.append(f'<path d="M55,290 L25,290 L40,255 L18,255 L40,225 L20,225 L40,195 Z" fill="white" stroke="{STROKE}" stroke-width="{SW}" stroke-linejoin="round"/>')
    parts.append(f'<path d="M40,195 l-4,-8 l8,0 z M40,187 l-2,-4 l4,0 z" fill="white" stroke="{STROKE}" stroke-width="1.2"/>')
    for i, (x, y) in enumerate(((30, 240), (45, 245), (35, 265), (50, 275), (32, 280))):
        parts.append(f'<circle cx="{x}" cy="{y}" r="2.5" fill="none" stroke="{STROKE}" stroke-width="1.2"/>')
    # cheering person at tree
    parts.append(stick_person(75, 280, action="cheer", seed=142))
    # party scene bottom right
    parts.append(f'<path d="M250,290 L350,290 L350,275 L250,275 Z" fill="white" stroke="{STROKE}" stroke-width="{SW_THIN}"/>')
    parts.append(stick_person(255, 270, action="cheer", seed=143))
    parts.append(stick_person(280, 270, action="cheer", seed=144))
    parts.append(stick_person(305, 270, action="cheer", seed=145))
    parts.append(stick_person(335, 270, action="wave", seed=146))
    return svg_wrap(parts)


def title_text_wide(text: str, sub: str = "クマガチの") -> str:
    return f'''
    <text x="20" y="30" font-family="'Noto Sans CJK JP', 'Yu Gothic', sans-serif" font-size="20"
          fill="{STROKE}" font-weight="700">{sub}</text>
    <text x="185" y="78" font-family="'Noto Sans CJK JP', 'Yu Gothic', sans-serif" font-size="36"
          fill="{STROKE}" font-weight="800" text-anchor="middle">{text}</text>
    '''


def svg_wrap(parts: list[str], w: int = STAMP_W, h: int = STAMP_H) -> str:
    body = "\n".join(parts)
    return f'''<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="{w}" height="{h}" viewBox="0 0 {w} {h}">
  <g fill="none" stroke-linecap="round" stroke-linejoin="round">
    {body}
  </g>
</svg>'''


# ---------- Main image (240x240) ----------

def main_image() -> str:
    parts = []
    parts.append(f'<text x="120" y="30" font-family="\'Noto Sans CJK JP\',sans-serif" font-size="22" text-anchor="middle" font-weight="800" fill="{STROKE}">クマガチ</text>')
    parts.append(kumagachi(120, 130, scale=0.7, seed=200))
    return svg_wrap(parts, 240, 240)


# ---------- Tab image (96x74) ----------

def tab_image() -> str:
    parts = []
    parts.append(kumagachi(48, 45, scale=0.32, seed=300))
    return svg_wrap(parts, 96, 74)


# ---------- Build ----------

STAMPS = {
    "01_haru": stamp_haru,
    "02_tsuyu": stamp_tsuyu,
    "03_natsu": stamp_natsu,
    "04_aki": stamp_aki,
    "05_fuyu": stamp_fuyu,
    "06_christmas": stamp_christmas,
    "07_nenmatsu": stamp_nenmatsu,
    "08_oshougatsu": stamp_oshougatsu,
}


def write_svg_and_png(name: str, svg: str) -> None:
    svg_path = SVG_DIR / f"{name}.svg"
    png_path = PNG_DIR / f"{name}.png"
    svg_path.write_text(svg, encoding="utf-8")
    cairosvg.svg2png(bytestring=svg.encode("utf-8"), write_to=str(png_path))
    print(f"  - {svg_path.name}  /  {png_path.name}")


def main() -> None:
    print("Building Kumagachi LINE stamps...")
    for name, fn in STAMPS.items():
        write_svg_and_png(name, fn())
    write_svg_and_png("main", main_image())
    write_svg_and_png("tab", tab_image())
    print("Done.")


if __name__ == "__main__":
    main()
