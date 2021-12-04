<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler
{
  
    protected $dontReport = [
        //
    ];

 
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    
 
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
             // emails.exception is the template of your email
             // it will have access to the $error that we are passing below

        if ($this->shouldReport($exception)) {
             $this->sendEmail($exception); // sends an email
        }

         return parent::report($exception);

    }

    public function sendEmail(Throwable $exception)
    {
       try {
            $e = FlattenException::create($exception);
            $handler = new HtmlErrorRenderer(true); // boolean, true raises debug flag...
            $css = $handler->getStylesheet();
            $errors = $handler->getBody($e);

            Mail::send('emails.exception', compact('css','errors'), function ($message) {
                $message->to(['test@western.com'])
                                    ->subject('Exception: ' . \Request::fullUrl());
            });
        } catch (Throwable $exception) {
            Log::error($exception);
        }
    }

}
