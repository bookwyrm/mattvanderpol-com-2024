<?php

namespace TailCraft\Theme\Util;

class ClassList {
    protected $class_list = [];

    public function __construct($class_arg = [])
    {
        if ( is_array($class_arg) ) {
            $this->class_list = $class_arg;
        } else if ( is_string($class_arg) ) {
            $this->class_list = preg_split('/\s+/', $class_arg);
        }
    }

    public function add($class_arg) {
        $this->class_list = array_merge(
            $this->class_list,
            is_array($class_arg) 
                ? $class_arg 
                : preg_split('/\s+/', $class_arg)
        );
    }

    public function remove($class_arg) {
        $class_arg = is_array($class_arg) ? $class_arg : preg_split('/\s+/', $class_arg);
        $this->class_list = array_diff(
            $this->class_list, $class_arg
        );
    }

    public function merge($class_arg) : void
    {
        $merge_classes = is_array($class_arg) 
            ? $class_arg
            : preg_split('/\s+/', $class_arg);
        ;

        $merge_class_types = [ ];
        $analyzer = new TailwindAnalyzer();

        foreach ( $merge_classes as $class ) {
            $type = $analyzer->type($class);
            $merge_class_types[$type] = $class;
        }

        foreach ( $this->class_list as $key => $class ) {
            $type = $analyzer->type($class);
            if ( !empty($merge_class_types[$type]) ) {
                $this->class_list[$key] = $merge_class_types[$type];
                unset($merge_class_types[$type]);
            }
        }

        if ( !empty($merge_class_types) ) {
            $this->add(array_values($merge_class_types));
        }
    }

    public function __toString() {
        return implode(' ', $this->class_list);
    }

    public function render() {
        $classes = (string) $this;
        if ( !empty($classes) ) {
            printf('class="%s"', esc_attr($classes));
        }
    }
}

