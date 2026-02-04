<?php

expect()->extend('toBeMena', function () {
    return $this->toBe("Mena")->toBeString()->not->toBeInt();
});
