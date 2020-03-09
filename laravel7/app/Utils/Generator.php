<?php


namespace App\Utils;


use Exception;

class Generator
{
    // seems stupid, maybe it is!
    public static function generateGarbagePassword(): string
    {
        // length : (10 / 3) * 4 = 14 [ceil]
        return self::generateGarbageBase64Text(10);
    }

    public static function generateResetLink(): string
    {
        // length : (15 / 3) * 4 = 20
        $reset_link = self::generateGarbageBase64Text(15);
        return str_replace('/', '_', $reset_link);
    }

    public static function generateGarbageBase64Text(int $length): string
    {
        // length : ($length / 3) * 4
        $garbage = self::generateGarbageText($length);
        return base64_encode($garbage);
    }

    public static function generateGarbageText(int $length): string
    {
        $text = "";
        $i = 0;
        do {
            try {
                $char_value = random_int(0, 255);
                if ($char_value < 32)
                    continue;
                $char = chr($char_value);
                $text .= $char;
            } catch (Exception $e) {
                dump("Cette plateforme ne dispose pas d'une fonction aléatoire cryptographique dont les résultats doivent être impartials : $e");
            }
            $i++;
        } while ($i < $length);
        return $text;
    }
}
