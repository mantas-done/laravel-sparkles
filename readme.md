## Laravel Sparkles

Laravel Sparkles is a collection of helpers that are often used in my Laravel project.  

## Instalation

```
composer require mantas-done/laravel-sparkles 1.*
```

## Usage

Get currently logged in user (the same as Auth::user())
```php
user();
```

Current user IP address
```php
ip();
```

#### delete()
Delete all models in collection
```php
delete($user->comments);

// equals to this
foreach ($user->comments as $comment) {
    $comment->delete();
}
```

Delete one model
```php
delete($user->profilePicture);

// equals to
if ($user->profilePicture) {
    $user->profilePicture->delete();
}
```

#### forceDelete()

The same as delete(), but force deletes records (for soft deletes).

#### bustCache()

Bust cache of files: CSS, images...  
It adds md5 hash of a file.
```php
echo bustCache('/css/app.css'); // /css/app.css?v=0c39e0bb074f164bc2e7e3e5854927c5
```

#### twoDigits()

Display currency with two digits.
```php
twoDigits(1.2);      // 1.20
twoDigits(1.234);    // 1.23
twoDigits(1, '$');   // $1.00
twoDigits(-1, '$');  // -$1.00
```

#### validate()

Controller request data validation
```php
// use
UserController extends Controller
{
    public function store() {
        validate([
            'email' => 'required|email',
        ]);
        
        // save user
    }
}

// instead of
UserController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        // save user
    }
}
```

Function data validation
```php
class Comment
{
    public static function saveComment($email, $comment) {
        validate([
            'email' => 'required|email',
            'comment' => 'required|string|between:1,256',
        ], compact('email', 'comment');
        
        // save comment
    }
}
```

#### deleteAllDirectoryFilesExceptGitignore()

When folder is created in /storag/app folder, usually it has .gitignore file added to it.  
When migrating and seeding database in development, it is beneficial to delete all files from some folders. 
 
```php
deleteAllDirectoryFilesExceptGitignore('/storage/app/uploads');
```

#### Cookies
Simplifies working with Laravel cookies. You can call those functions from anywhere in your code unlike Laravel cookie implementation.
```php
cookieSet('name', 'value');
cookieGet('name');
cookieForget('name');
```

#### paginate()
Paginates collection or array and returns default Laravel paginator.
```php
$users_array = [[
    'email' => 'abc@abc.com',
    'name' => 'Abc',
], [
    'email' => 'bcd@bcd.com',
    'name' => 'Bcd',
]];

$users = paginate($users_array);

return view('users.index', compact('users');
```

#### faker()
Get instance of a faker
````php
echo faker()->email;
````

## Contributing

I decided to share my helpers when I saw that similar concepts got implemented in Laravel, like **artisan fresh** and **now()**.  
I believe that other developers have their own gems hidden in their code. If you would like to share one of them, please create a pull request.

