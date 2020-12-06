<?php
namespace App\Core;

use App\Facades\Http\Response;
use App\Facades\Parser\Achievements;
use App\Facades\Parser\Items;
use App\Facades\Validator\Validator;
use App\Helpers\Loader;
use App\Helpers\Session;
use App\Helpers\Storage;
use App\Facades\Http\View;
use App\Facades\Http\Router;

abstract class Controller
{
    protected array $user;
    
    const PER_PAGE = 60;
    
    const REQUEST_PER_SECOND = 2;
    
    public function __construct()
    {
        $this->perSecond();
        $this->boot();
    }
    
    public function boot()
    {
        Storage::disk('private')->make('logs');
    
        $this->set([
            'messages' => Session::getMsg(),
            'color' => Session::getColor(),
            'css' => Loader::css(),
            'js' => Loader::js()
        ]);
    
        if ($vars = Session::collectProvidedData())
            View::set($vars);
        
        if (Session::has('user')) {
            $this->user = Session::get('user');
        }
    
        Session::clearMsg();
    }

    public function redirect(?string $path, int $code=302, bool $direct=false)
    {
        return Router::redirect($path, $code, $direct);
    }
    
    public function set(array $data): void
    {
        View::set($data);
    }
    
    public function render(array $data = [])
    {
        if(empty($data) === false)
            return View::render($data);
        
        return View::render();
    }
    
    public function validate(array $request, array $rules)
    {
        return Validator::make($request, $rules);
    }
    
    public function sendSuccess(?string $message, string $to = null, int $status = 201 ,array $headers = []): string
    {
        return Response::json(['ok' => true, 'msg' => [$message ?? 'Dane zostały zapisane'], 'to' => $to], $status, $headers);
    }
    
    public function sendError(string $message=null, int $status = 200, array $headers = []): string
    {
        return Response::json(['ok' => false, 'msg' => $message ?? Validator::getErrors()], $status, $headers);
    }
    
    public function getDate()
    {
        return date('Y-m-d H:i:s');
    }
    
    private function perSecond()
    {
        $flash = Session::getFlash();
        
        if (! Session::hasFlash('last_request')) {
            Session::flash('last_request', time(), 5);
        } else {
            Session::flash('request_count', ((int) $flash['request_count']+1), 5);
        }
        
        if ($flash['request_count'] > self::REQUEST_PER_SECOND && $flash['last_request'] > strtotime('- 1 seconds')) {
            http_response_code(431);
            exit(require_once view_path('errors/too-many-requests.php'));
        }
    }
}
