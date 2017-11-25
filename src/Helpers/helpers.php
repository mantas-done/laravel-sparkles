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
    /**
     * Deletes one model or every model in collection
     *
     * @param $model_or_collection
     */
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

        throw new \Exception("Unknown type of object");
    }
}

if (!function_exists('forceDelete')) {
    /**
     * Force deletes one model or every model in collection
     *
     * @param $model_or_collection
     */
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
    /**
     * Busts browser cache of files
     *
     * @param $public_file_path
     *
     * @return string
     */
    function bustCache($public_file_path) {
        $public_file_path = '/' . ltrim($public_file_path, '/');
        $php_public_path = public_path();
        $file_md5 = md5_file($php_public_path . $public_file_path);

        $new_path = $public_file_path . '?v=' . $file_md5;

        return $new_path;
    }
}

if (!function_exists('twoDigits')) {
    /**
     * Returns number with 2 digits after comma. Used to display currency
     *
     * @param      $number
     * @param null $prefix
     *
     * @return string
     */
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
    /**
     * Deletes all files in directory except .gitignore
     *
     * @param $directory
     */
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
    /**
     * Set cookie
     *
     * @param $name
     * @param $value
     * @param $minutes
     */
    function cookieSet($name, $value, $minutes) {
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::make($name, $value, $minutes));
    }
}

if (!function_exists('cookieGet')) {
    /**
     * Get cookie
     *
     * @param $name
     * @param $default
     *
     * @return string
     */
    function cookieGet($name, $default) {
        return \Illuminate\Support\Facades\Cookie::get($name, $default);
    }
}

if (!function_exists('cookieForget')) {
    /**
     * Forget cookie
     *
     * @param $name
     */
    function cookieForget($name) {
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget($name));
    }
}

if (!function_exists('paginate')) {
    /**
     * Paginates collection or array
     *
     * @param     $collection_or_array
     * @param int $per_page
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
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
    /**
     * Return instance of faker
     *
     * @return \Faker\Generator|null
     */
    function faker() {
        static $faker = null;
        if (!$faker) {
            $faker = Faker\Factory::create();
        }

        return $faker;
    }
}