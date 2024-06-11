<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class HelpWebhookController extends Controller
{
    public function zendesk(Request $req)
    {
        Log::info($req);
    }
}
