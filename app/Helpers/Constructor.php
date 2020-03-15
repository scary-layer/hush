<?php

namespace ScaryLayer\Hush\Helpers;

use Closure;

class Constructor
{
    public static function link($item)
    {
        $link = '#';
        if (isset($item['route'])) {
            $link = route($item['route']);
        } elseif (isset($item['constructor'])) {
            $link = is_string($item['constructor'])
                ? route('admin.constructor', ['url' => str_replace('.', '/', $item['constructor'])])
                : route(
                    $item['constructor']['route'] ?? 'admin.constructor',
                    collect($item['constructor'])
                        ->except('route', 'url')
                        ->merge(['url' => str_replace('.', '/', $item['constructor']['url'] ?? request()->url)])
                        ->all()
                );
        } elseif (isset($item['link'])) {
            $link = $item['link'];
        } elseif (isset($item['closure'])) {
            $link = call_user_func($item['closure']);
        }

        return $link;
    }

    public static function value($variables, $item, $default = null)
    {
        if (isset($item['field'])) {
            return isset($variables['model']) && isset($variables['model'][$item['field']])
                ? $variables['model'][$item['field']]
                : null;
        } elseif (isset($item['value'])) {
            return self::closureDetector($item['value'], $variables);
        } elseif (isset($item['name'])) {
            return isset($variables['model']) && isset($variables['model'][$item['name']])
                ? $variables['model'][$item['name']]
                : null;
        }

        return $default;
    }

    public static function closureDetector($value, $params = null)
    {
        return $value instanceof Closure
            ? call_user_func($value, $params)
            : $value;
    }
}
