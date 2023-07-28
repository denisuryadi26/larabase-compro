<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Service\Api\FaqService;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    protected $faqService;
    //

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index(Request $request)
    {
        $faq = $this->faqService->getFAQ($request);

        return FaqResource::collection($faq);
    }
}
