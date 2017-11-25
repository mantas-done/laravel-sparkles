<?php

if (!function_exists('user')) {
    /**
     * Get currently logged in user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user() {
        return \Illuminate\Support\Facades\Auth::user();
    }
}

if (!function_exists('ip')) {
    /**
     * Return client ip address
     *
     * @return string
     */
    function ip() {
        return request()->ip();
    }
}

if (!function_exists('validate')) {
    /**
     * Validate request data. If second parameter is used, then validates passed data
     *
     * @param array      $rules
     * @param array|null $data
     */
    function validate(array $rules, array $data = null) {
        if ($data === null) {
            return request()->validate($rules);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            $tmp = $validator->messages()->toArray();
            $tmp = reset($tmp);
            $first_message = reset($tmp);

            throw new \InvalidArgumentException($first_message);
        }
    }
}

if (!function_exists('delete')) {
    function delete($model_or_collection) {
        if (is_subclass_of($model_or_collection, \Illuminate\Database\Eloquent\Model::class)) {
            if ($model_or_collection) {
                $model_or_collection->delete();
            }
        } elseif (is_subclass_of($model_or_collection, \Illuminate\Support\Collection::class)) {
            foreach ($model_or_collection as $model) {
                $model->delete();
            }
        }
    }
}

if (!function_exists('forceDelete')) {
    function forceDelete($model_or_collection) {
        if (is_subclass_of($model_or_collection, \Illuminate\Database\Eloquent\Model::class)) {
            if ($model_or_collection) {
                $model_or_collection->forceDelete();
            }
        } elseif (is_subclass_of($model_or_collection, \Illuminate\Support\Collection::class)) {
            foreach ($model_or_collection as $model) {
                $model->forceDelete();
            }
        }
    }
}

if (!function_exists('bustCache')) {
    function bustCache($public_file_path) {
        $public_file_path = '/' . ltrim($public_file_path, '/');
        $php_public_path = public_path();
        $file_md5 = md5_file($php_public_path . $public_file_path);

        $new_path = $public_file_path . '?v=' . $file_md5;

        return $new_path;
    }
}

if (!function_exists('twoDigits')) {
    function twoDigits($number, $prefix = null) {
        $digits = 2;
        if ($number < 0) {
            return '-' . $prefix . number_format(abs($number), $digits, '.', '');
        } else {
            return $prefix . number_format($number, $digits, '.', '');
        }
    }
}

if (!function_exists('deleteAllDirectoryFilesExceptGitignore')) {
    function deleteAllDirectoryFilesExceptGitignore($directory) {
        $leave_files = array('.gitignore');

        foreach(glob("$directory/*") as $file ) {
            if (!in_array(basename($file), $leave_files)){
                unlink($file);
            }
        }
    }
}

if (!function_exists('cookieSet')) {
    function cookieSet($name, $value, $minutes) {
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::make($name, $value, $minutes));
    }
}

if (!function_exists('cookieGet')) {
    function cookieGet($name, $default) {
        return \Illuminate\Support\Facades\Cookie::get($name, $default);
    }
}

if (!function_exists('cookieForget')) {
    function cookieForget($name) {
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget($name));
    }
}

if (!function_exists('paginate')) {
    function paginate($collection_or_array, $per_page = 100) {
        if (is_array($collection_or_array)) {
            $collection = collect($collection_or_array);
        }
        $current_page = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $paginated_collection = new \Illuminate\Pagination\LengthAwarePaginator($collection->slice(($current_page - 1) * $per_page, $per_page), $collection->count(), $per_page);
        $paginated_collection->setPath(\Illuminate\Support\Facades\Request::url());

        return $paginated_collection;
    }
}

if (!function_exists('faker')) {
    function faker() {
        static $faker = null;
        if (!$faker) {
            $faker = Faker\Factory::create();
        }

        return $faker;
    }
}