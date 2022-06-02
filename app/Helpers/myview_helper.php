<?php

function isMenuOpen(string $module, int $segment = 0) {
    $segments = service('uri')->getSegments();
    if (count($segments) == 1) {
        return '';
    }

    try {
        return $segments[$segment - 1] == $module ? 'block' : 'none';
    } catch (Exception $e) {
        return '';
    }
}

function isLinkActive(string $module, int $segment = 0, string $parent = null) {
    $segments = service('uri')->getSegments();
    try {
        if (!is_null($parent)) {
            $isEqualParent = false;
            $isEqualChild = false;
            if ($segments[1] == $parent) {
                $isEqualParent = true;
            }
            if ($segment[2] == $module) {
                $isEqualChild = true;
            }
            return ($isEqualParent && $isEqualChild) ? 'active' : '';
        } else {
            return $segments[$segment - 1] == $module ? 'active' : '';
        }
    } catch (Exception $e) {
        return '';
    }
}

function isLinkActiveColor(string $module, int $segment = 0, string $color) {
    $segments = service('uri')->getSegments();
    if (count($segments) == 1) {
        return $color;
    }

    try {
        return $segments[$segment - 1] == $module ? 'white' : $color;
    } catch (Exception $e) {
        return $color;
    }
}