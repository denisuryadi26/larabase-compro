<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service\Api;


use App\Models\Generator\Aux;
use App\Models\Generator\Employee;
use App\Models\Group;
use App\Models\User;
use App\Repository\Generator\AuxRepository;
use App\Repository\Generator\FAQRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;
use Tymon\JWTAuth\Facades\JWTAuth;
use function App\Helpers\clearToken;

class FaqService extends CoreService
{
    protected $accessToken = '';
    protected $faqRepository;

    public function __construct(FAQRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function getFAQ($request)
    {
        $search = [];
        $sortColumn = $request->get('sortColumn');
        $sortDirection = "ASC";
        $page = $request->get('page');
        $perPage = $request->get('per_page');

        if ($request->get('search')){
            $search['search'] = $request->get('search');
        }

        if ($request->get('sortDirection')){
            $sortDirection = $request->get('sortDirection');
        }

        $faqs = $this->faqRepository->getFAQAPI( $search, $sortColumn, $sortDirection, $page, $perPage);
        return $faqs;
    }






}
