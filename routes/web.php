<?php

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('chat', function () {
    return view('chat');
});

Route::post('message', function (Request $request) {
    // Tiến hành gửi event đi bằng cách gọi broadcast new messagesent để gửi message đi( gửi đến redis) cần cài redis server
    // Truyền người đang login vào
    // Cần broadcast đến redis server phải vào .env sửa broadcast_driver=redis tiếp theo config/app.php mở broadcastServiceProvider
    broadcast(new MessageSent(auth()->user(), $request->input('message')));

    return $request->input('message');
});

Route::get('login/{id}', function ($id) {
    Auth::loginUsingId($id);

    return back();
});

Route::get('logout', function () {
    Auth::logout();

    return back();
});
