<?php

namespace App\Services;

class DiscChartService
{
    /**
     * Generate a high-resolution base64 PNG line chart for DISC scores (-8 to +8).
     *
     * @param  array<string, float|int>  $scores  e.g. ['D' => 2.1, 'I' => -1.2, 'S' => 0.0, 'C' => 1.4]
     * @param  string  $theme  'most' | 'least' | 'change'
     * @return string Data URI (data:image/png;base64,...)
     */
    public function generateLineChart(array $scores, string $theme = 'most'): string
    {
        // High-DPI resolution with taller aspect ratio and compact vertical footprint
        $w = 280;
        $h = 230;
        $img = imagecreatetruecolor($w, $h);
        imagealphablending($img, true);
        imagesavealpha($img, true);

        // Colors (Professional Corporate Palette)
        $white = imagecolorallocate($img, 255, 255, 255);
        $cardBg = imagecolorallocate($img, 255, 255, 255); // Clean white background
        $gridColor = imagecolorallocate($img, 226, 232, 240); // Slate-200
        $subGridColor = imagecolorallocate($img, 241, 245, 249); // Slate-100
        $textColor = imagecolorallocate($img, 100, 116, 139); // Slate-500
        $axisTextColor = imagecolorallocate($img, 15, 23, 42); // Slate-900
        $zeroLineColor = imagecolorallocate($img, 51, 65, 85); // Slate-700

        // Subdued Theme Colors (Executive Navy / Slate)
        if ($theme === 'most') {
            $lineColor = imagecolorallocate($img, 30, 58, 138); // Navy (blue-900)
            $badgeBg = imagecolorallocate($img, 241, 245, 249); // Slate-100
            $badgeBorder = imagecolorallocate($img, 203, 213, 225); // Slate-300
            $badgeText = imagecolorallocate($img, 15, 23, 42); // Slate-900
            $dotFill = imagecolorallocate($img, 30, 58, 138);
        } elseif ($theme === 'least') {
            $lineColor = imagecolorallocate($img, 71, 85, 105); // Slate-600
            $badgeBg = imagecolorallocate($img, 241, 245, 249); // Slate-100
            $badgeBorder = imagecolorallocate($img, 203, 213, 225); // Slate-300
            $badgeText = imagecolorallocate($img, 15, 23, 42); // Slate-900
            $dotFill = imagecolorallocate($img, 71, 85, 105);
        } else {
            $lineColor = imagecolorallocate($img, 15, 23, 42); // Dark Slate (slate-900)
            $badgeBg = imagecolorallocate($img, 241, 245, 249); // Slate-100
            $badgeBorder = imagecolorallocate($img, 203, 213, 225); // Slate-300
            $badgeText = imagecolorallocate($img, 15, 23, 42); // Slate-900
            $dotFill = imagecolorallocate($img, 15, 23, 42);
        }

        // Fill background
        imagefilledrectangle($img, 0, 0, $w, $h, $cardBg);

        // Chart coordinates (taller chart height and narrower margins for compact DISC distance)
        $marginLeft = 32;
        $marginRight = 14;
        $marginTop = 18;
        $marginBottom = 28;
        $chartW = $w - $marginLeft - $marginRight;
        $chartH = $h - $marginTop - $marginBottom;

        $getY = function (float $score) use ($marginTop, $chartH) {
            $val = max(-8, min(8, $score));
            $ratio = (8 - $val) / 16;

            return (int) round($marginTop + ($ratio * $chartH));
        };

        // Draw sub-grid lines (+6, +2, -2, -6)
        imagesetthickness($img, 1);
        foreach ([6, 2, -2, -6] as $step) {
            $gy = $getY((float) $step);
            imagedashedline($img, $marginLeft, $gy, $w - $marginRight, $gy, $subGridColor);
        }

        // Draw primary grid lines (+8, +4, 0, -4, -8)
        foreach ([8, 4, 0, -4, -8] as $step) {
            $gy = $getY((float) $step);
            if ($step === 0) {
                imagesetthickness($img, 2);
                imageline($img, $marginLeft, $gy, $w - $marginRight, $gy, $zeroLineColor);
                imagesetthickness($img, 1);
                // Zero indicator label
                imagestring($img, 3, 12, $gy - 7, ' 0', $zeroLineColor);
            } else {
                imagedashedline($img, $marginLeft, $gy, $w - $marginRight, $gy, $gridColor);
                $lbl = $step > 0 ? "+{$step}" : (string) $step;
                imagestring($img, 2, 8, $gy - 6, $lbl, $textColor);
            }
        }

        // X Positions for D, I, S, C columns
        $dims = ['D', 'I', 'S', 'C'];
        $stepX = $chartW / 3;
        $coords = [];

        foreach ($dims as $idx => $dim) {
            $cx = (int) round($marginLeft + ($idx * $stepX));
            $val = (float) ($scores[$dim] ?? 0);
            $cy = $getY($val);
            $coords[$dim] = ['x' => $cx, 'y' => $cy, 'val' => $val];

            // Vertical dashed grid line
            imagedashedline($img, $cx, $marginTop, $cx, $h - $marginBottom, $gridColor);

            // Bottom Dimension Label (D, I, S, C)
            imagestring($img, 5, $cx - 5, $h - $marginBottom + 8, $dim, $axisTextColor);
        }

        // Draw connecting thick line graph (D -> I -> S -> C)
        imagesetthickness($img, 4);
        for ($i = 0; $i < 3; $i++) {
            $dim1 = $dims[$i];
            $dim2 = $dims[$i + 1];
            imageline($img, $coords[$dim1]['x'], $coords[$dim1]['y'], $coords[$dim2]['x'], $coords[$dim2]['y'], $lineColor);
        }

        // Draw data points and score badge boxes
        imagesetthickness($img, 1);
        foreach ($dims as $dim) {
            $pt = $coords[$dim];
            $px = $pt['x'];
            $py = $pt['y'];
            $val = $pt['val'];

            // Outer white ring
            imagefilledellipse($img, $px, $py, 16, 16, $white);
            // Inner colored circle
            imagefilledellipse($img, $px, $py, 11, 11, $dotFill);

            // Badge text formatting
            $valStr = ($val > 0 ? '+' : '').number_format($val, 1);
            $textWidth = strlen($valStr) * 7;
            $badgeY = ($val >= 0) ? $py - 22 : $py + 9;

            // Rounded badge rectangle
            $bx1 = (int) round($px - ($textWidth / 2) - 4);
            $by1 = $badgeY - 1;
            $bx2 = (int) round($px + ($textWidth / 2) + 4);
            $by2 = $badgeY + 12;

            imagefilledrectangle($img, $bx1, $by1, $bx2, $by2, $badgeBg);
            imagerectangle($img, $bx1, $by1, $bx2, $by2, $badgeBorder);
            imagestring($img, 2, (int) round($px - ($textWidth / 2)), $badgeY, $valStr, $badgeText);
        }

        ob_start();
        imagepng($img);
        $data = ob_get_clean();
        imagedestroy($img);

        return 'data:image/png;base64,'.base64_encode($data);
    }
}
