<?php

namespace App\Service\Parsers;

class ParserUtils {
    public function generateHash($feedType, $originalId) {
        return $originalId . '_' . $feedType;
    }
}
