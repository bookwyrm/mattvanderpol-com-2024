<?php

namespace TailCraft\Theme\Util;

class TailwindAnalyzer {

    public function __construct()
    {
    }

    public function type($class) : string
    {

        /* ray('class: ' . $class); */
        if ( 
            strpos($class, '--' ) !== false 
            || strpos($class, '__' ) !== false 
            
        ) {
            return $class;
        }

        if ( strpos($class, '-') === false ) {
            $special_type = $this->specialType($class);
            return empty($special_type) ? $class : $special_type;
        }

        return $this->parseType($class);
    }

    protected function isObjectPosition($class) 
    {
        $sides = ['right', 'left'];
        $elevations = [ 'top', 'bottom' ];
        $options = [ 'object-center' ];
        foreach ( $sides as $side ) {
            $options[]= 'object-' . $side;
            foreach ( $elevations as $elevation ) {
                $options[]= 'object-' . $elevation;
                $options[]= 'object-' . $side . '-' . $elevation;
            }
        }

        return in_array(
            $class,
            $options
        );
    }

    protected function isObjectFit($class) {
        return in_array(
            $class,
            [ 'object-contain', 'object-cover', 'object-fill', 'object-none', 'object-scale-down' ]
        );
    }

    protected function parseType($class) {
        if ( $this->isObjectPosition($class) ) {
            return 'object-position';
        }

        if ( $this->isObjectFit($class) ) {
            return 'object-fit';
        }

        list($type, $value) = explode('-', $class, 2);
        $bang = false;
        if ( substr($type, 0, 1) === '!' ) {
            $bang = true;
            $type = substr($type, 1);
        }

        return $type;
    }

    protected function specialType($class) {
        if ( in_array($class, ['relative', 'absolute', 'fixed']) ) {
            return 'position';
        }

        if ( in_array($class, ['block', 'inline', 'inline-block', 'flex']) ) {
            return 'display';
        }

        return '';
    }
}
