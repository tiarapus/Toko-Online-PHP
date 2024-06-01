<?php

function truncateText($text, $maxLength, $suffix = '...')
{
    if (mb_strlen($text) > $maxLength) {
        $truncatedText = mb_substr($text, 0, $maxLength - mb_strlen($suffix)) . $suffix;
        return $truncatedText;
    }
    return $text;
}

function formatRupiah($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
