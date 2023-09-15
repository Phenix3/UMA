<?php

declare(strict_types=1);

test('Test', static function (): void {
    $result = 1 + 2;

    expect($result)->toBe(3);
});
