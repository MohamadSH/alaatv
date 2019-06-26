<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use SEO;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use League\Flysystem\Filesystem;
use App\Http\Controllers\Controller;
use League\Flysystem\Sftp\SftpAdapter;
use App\Console\Commands\CategoryTree\Ensani;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\{DB, File, Input, Route, Config, Storage};
use App\{
    User,
    Event,
    Major,
    Product,
    Question,
    Eventresult,
    Productfile,
    Traits\Helper,
    Websitesetting,
    Usersurveyanswer,
    Traits\UserCommon,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Http\Requests\Request,
    Traits\CharacterCommon,
    Traits\APIRequestCommon,
    Http\Requests\ContactUsFormRequest,
    Classes\Format\BlockCollectionFormatter,
    Classes\Repository\ContentRepositoryInterface,
    Classes\Repository\ProductRepository as ProductRepository};

class HomeController extends Controller
{
    use Helper;
    use APIRequestCommon;
    use ProductCommon;
    use CharacterCommon;
    use UserCommon;
    use RequestCommon;

    private static $TAG = HomeController::class;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $response;
    
    protected $sideBarAdmin;
    
    protected $setting;
    
    public function __construct(Response $response, Websitesetting $setting)
    {
        $this->response = $response;
        $this->setting  = $setting->setting;


        $authException = [
//            'debug',
            'newDownload',
            'download',
            'telgramAgent',
            'index',
            'getImage',
            'error404',
            'error403',
            'error500',
            'errorPage',
            'aboutUs',
            'contactUs',
            'sendMail',
            'rules',
            'siteMapXML',
//            'uploadFile',
            'search',
            'schoolRegisterLanding',
            'lernitoTree',
            'getTreeInPHPArrayString',
        ];
        //        }
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('role:admin', ['only' => 'debug']);
    }

    public function test(Product $product)
    {
        return $product;
    }

    public function debug(Request $request, BlockCollectionFormatter $formatter)
    {
        if($request->has('product') && $request->has('contents'))
        {
            $product = Product::find($request->get('product'));
            $contents = \App\Content::whereIn('id' , $request->get('contents'))->get();
            $tags = [];
            foreach ($contents as $content) {
                array_push($tags , 'c-'.$content->id);
            }

            $params = [
                "tags" => json_encode($tags, JSON_UNESCAPED_UNICODE),
            ];

            if (isset($product->created_at) && strlen($product->created_at) > 0) {
                $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s", $product->created_at)->timestamp;
            }

            $response = $this->sendRequest(config("constants.TAG_API_URL")."id/relatedproduct/".$product->id, "PUT", $params);
            dump($response);

            dd('done');

        }

        return (array) optional($request->user('alaatv'))->id;
    }
    
    public function search(Request $request)
    {
        return redirect(action("Web\ContentController@index"), Response::HTTP_MOVED_PERMANENTLY);
    }
    
    public function home()
    {
        return redirect('/', 301);
    }
    
    /**
     * Show the not found page.
     *
     * @return Response
     */
    public function error404()
    {
        return abort(404);
    }
    
    /**
     * Show forbidden page.
     *
     * @return Response
     */
    public function error403()
    {
        return abort(403);
    }
    
    /**
     * Show general error page.
     *
     * @return Response
     */
    public function error500()
    {
        return abort(500);
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function consultantEntekhabReshte()
    {
        $user = User::FindOrFail(Input::get('user'));
        if (Storage::disk('entekhabReshte')
            ->exists($user->id.'-'.$user->major->id.'.txt')) {
            $storedMajors     = json_decode(Storage::disk('entekhabReshte')
                ->get($user->id.'-'.$user->major->id.'.txt'));
            $parentMajorId    = $user->major->id;
            $storedMajorsInfo = Major::whereHas('parents', function ($q) use ($storedMajors, $parentMajorId) {
                $q->where('major1_id', $parentMajorId)
                    ->whereIn('majorCode', $storedMajors);
            })
                ->get();
            
            $selectedMajors = [];
            foreach ($storedMajorsInfo as $storedMajorInfo) {
                $storedMajor    = $storedMajorInfo->parents->where('id', $parentMajorId)
                    ->first();
                $majorCode      = $storedMajor->pivot->majorCode;
                $majorName      = $storedMajorInfo->name;
                $selectedMajors = array_add($selectedMajors, $majorCode, $majorName);
            }
        }
        $eventId       = 1;
        $surveyId      = 1;
        $requestUrl    = action("Web\UserSurveyAnswerController@index");
        $requestUrl    .= '?event_id[]='.$eventId.'&survey_id[]='.$surveyId.'&user_id[]='.$user->id;
        $originalInput = \Illuminate\Support\Facades\Request::input();
        $request       = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
        \Illuminate\Support\Facades\Request::replace($request->input());
        $response          = Route::dispatch($request);
        $answersCollection = json_decode($response->content());
        \Illuminate\Support\Facades\Request::replace($originalInput);
        $userSurveyAnswers = collect();
        foreach ($answersCollection as $answerCollection) {
            $answerArray    = $answerCollection->userAnswer->answer;
            $question       = Question::FindOrFail($answerCollection->userAnswer->question_id);
            $requestBaseUrl = $question->dataSourceUrl;
            $requestUrl     = url('/').$requestBaseUrl."?ids=$answerArray";
            $originalInput  = \Illuminate\Support\Facades\Request::input();
            $request        = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
            \Illuminate\Support\Facades\Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            \Illuminate\Support\Facades\Request::replace($originalInput);
            $userSurveyAnswers->push([
                'questionStatement' => $question->statement,
                'questionAnswer'    => $dataJson,
            ]);
        }
        
        //        Meta::set('title', substr("آلاء|پنل انتخاب رشته", 0, config("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));
    
        return view('admin.consultant.consultantEntekhabReshte',
            compact('user', 'storedMajors', 'selectedMajors', 'userSurveyAnswers'));
    }
    
    /**
     * Show consultant admin entekhab reshte
     *
     * @return Response
     */
    public function consultantEntekhabReshteList()
    {
        $eventId           = 1;
        $surveyId          = 1;
        $usersurveyanswers = Usersurveyanswer::where('event_id', $eventId)
            ->where('survey_id', $surveyId)
            ->get()
            ->groupBy('user_id');
        
        //        Meta::set('title', substr("آلاء|لیست انتخاب رشته", 0, config("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));
    
        return view('admin.consultant.consultantEntekhabReshteList', compact('usersurveyanswers'));
    }
    
    /**
     * Storing consultant entekhab reshte
     *
     * @return Response
     */
    public function consultantStoreEntekhabReshte(\Illuminate\Http\Request $request)
    {
        $userId      = $request->get('user');
        $user        = User::FindOrFail($userId);
        $parentMajor = $request->get('parentMajor');
        $majorCodes  = json_encode($request->get('majorCodes'), JSON_UNESCAPED_UNICODE);
        
        Storage::disk('entekhabReshte')
            ->delete($userId.'-'.$parentMajor.'.txt');
        Storage::disk('entekhabReshte')
            ->put($userId.'-'.$parentMajor.'.txt', $majorCodes);
        session()->put('success', 'رشته های انتخاب شده با موفقیت درج شدند');
    
        return redirect(action("Web\HomeController@consultantEntekhabReshte", ['user' => $user]));
    }
    
    /**
     * @param  Request                                             $request
     * @param                                                      $data
     *
     * @param  ContentRepositoryInterface                          $contentRepository
     *
     * @return RedirectResponse|Redirector
     */
    public function newDownload(Request $request, $data, ContentRepositoryInterface $contentRepository)
    {
        /** @var User $user */
        $user = $request->user('alaatv');
        if ($user === null) {
            abort(403, 'Not authorized.');
        }
        if ($data === null) {
            abort(403, 'Invalid Link');
        }
        try {
            $data = (array) decrypt($data);
        } catch (DecryptException $e) {
            abort(403, 'invalid Data!');
        }
        $url       = $data['url'];
        $contentId = $data['data']['content_id'];
        $content   = $contentRepository->getContentById($contentId);
        if (!$user->hasContent($content)) {
            return redirect()
                ->action('Web\ContentController@show', $content)
                ->setStatusCode(Response::HTTP_FOUND);
        }
        $finalLink = $this->getSecureUrl($url);
    
        return redirect($finalLink);
    }
    
    /**
     * @param $url
     *
     * @return string
     */
    private function getSecureUrl($url): string
    {
        $unixTime = Carbon::today()
            ->addDays(2)->timestamp;
        $userIP   = request()->ip();
        //TODO: fix diffrent Ip
        $ipArray    = explode('.', $userIP);
        $ipArray[3] = 0;
        $userIP     = implode('.', $ipArray);
    
        $linkHash  = $this->generateSecurePathHash($unixTime, $userIP, 'TakhteKhak', $url);
        $finalLink = $url.'?md5='.$linkHash.'&expires='.$unixTime;
        return $finalLink;
    }
    
    function download(Request $request)
    {
        $fileName    = $request->get('fileName');
        $contentType = $request->get('content');
        /** @var User $user */
        $user = auth()->user();
        
        switch ($contentType) {
            case 'عکس پروفایل':
                $diskName = config('constants.DISK1');
                break;
            case 'عکس محصول':
                $diskName = config('constants.DISK4');
                break;
            case 'تمرین':
                // check if he has permission for downloading the assignment :
                
                //if(!Auth::user()->permissions->contains(Permission::all()->where("name", config('constants.DOWNLOAD_ASSIGNMENT_ACCESS'))->first()->id)) return redirect(action(("HomeController@error403"))) ;
                //  checking permission through the user's role
                //$user->hasRole('goldenUser');
                $diskName = config('constants.DISK2');
                break;
            case 'پاسخ تمرین':
                $diskName = config('constants.DISK3');
                break;
            case 'کاتالوگ محصول':
                $diskName = config('constants.DISK5');
                break;
            case 'سؤال مشاوره ای':
                $diskName = config('constants.DISK6');
                break;
            case 'تامبنیل مشاوره':
                $diskName = config('constants.DISK7');
                break;
            case 'عکس مقاله' :
                $diskName = config('constants.DISK8');
                break;
            case 'عکس اسلاید صفحه اصلی' :
                $diskName = config('constants.DISK9');
                break;
            case 'فایل سفارش' :
                $diskName = config('constants.DISK10');
                break;
            case 'فایل محصول' :
                $productId = Input::get('pId');
                $diskName  = config('constants.DISK13');
    
                if (isset($user) && !$user->can(config('constants.DOWNLOAD_PRODUCT_FILE'))) {
                    $products    = ProductRepository::getProductsThatHaveValidProductFileByFileNameRecursively($fileName);
                    $validOrders = $user->getOrdersThatHaveSpecificProduct($products);
                    
                    if (!$products->isEmpty()) {
                        if (!$validOrders->isEmpty()) {
                            $productId = (array) $productId;
                            if (isset($products)) {
                                $productId = array_merge($productId, $products->pluck('id')
                                    ->toArray());
                            }
                            $externalLink = (new Productfile)->getExternalLinkForProductFileByFileName($fileName,
                                $productId);
                            break;
                        }
                        $message = $this->getMessageThatShouldByWhichProducts($products);
                        return $this->errorPage($message);
                    }
                    $message = 'چنین فایلی وجود ندارد ویا غیر فعال شده است';
                    return $this->errorPage($message);
                }
                break;
            case 'فایل کارنامه' :
                $diskName = config('constants.DISK14');
                break;
            case config('constants.DISK18') :
                if (Storage::disk(config('constants.DISK18_CLOUD'))
                    ->exists($fileName)) {
                    $diskName = config('constants.DISK18_CLOUD');
                } else {
                    $diskName = config('constants.DISK18');
                }
                break;
            case config('constants.DISK19'):
                if (Storage::disk(config('constants.DISK19_CLOUD'))
                    ->exists($fileName)) {
                    $diskName = Config::  get('constants.DISK19_CLOUD');
                } else {
                    $diskName = config('constants.DISK19');
                }
                break;
            case config('constants.DISK20'):
                if (Storage::disk(config('constants.DISK20_CLOUD'))
                    ->exists($fileName)) {
                    $diskName = Config::  get('constants.DISK20_CLOUD');
                } else {
                    $diskName = config('constants.DISK20');
                }
                break;
            default :
                $file = \App\File::where('uuid', $fileName)
                    ->get();
                if ($file->isNotEmpty() && $file->count() == 1) {
                    $file = $file->first();
                    if ($file->disks->isNotEmpty()) {
                        $diskName = $file->disks->first()->name;
                        $fileName = $file->name;
                    } else {
                        $externalLink = $file->name;
                    }
                } else {
                    abort('404');
                }
        }
        if (isset($downloadPriority) && strcmp($downloadPriority, 'cloudFirst') == 0) {
            if (isset($externalLink)) {
                return redirect($externalLink);
            }
    
            if (Storage::disk($diskName)
                ->exists($fileName)) {
                $filePrefixPath = Storage::drive($diskName)
                    ->getAdapter()
                    ->getPathPrefix();
                if (isset($filePrefixPath)) {
                    $fs     = Storage::disk($diskName)
                        ->getDriver();
                    $stream = $fs->readStream($fileName);
            
                    return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                        fpassthru($stream);
                    }, 200, [
                        'Content-Type'        => $fs->getMimetype($fileName),
                        'Content-Length'      => $fs->getSize($fileName),
                        'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
                    ]);
                }
        
                $fileHost = Storage::drive($diskName)
                    ->getAdapter()
                    ->getHost();
                if (isset($fileHost)) {
                    $fileRoot = Storage::drive($diskName)
                        ->getAdapter()
                        ->getRoot();
                    //TODO: verify "$fileRemotePath = "http://" . $fileHost . ":8090" . "/public" . explode("public", $fileRoot)[1];"
            
                    $fileRemotePath = config('constants.DOWNLOAD_HOST_PROTOCOL').config('constants.DOWNLOAD_HOST_NAME').'/public'.explode('public',
                            $fileRoot)[1];
            
                    return response()->redirectTo($fileRemotePath.$fileName);
                }
        
                $fs     = Storage::disk($diskName)
                    ->getDriver();
                $stream = $fs->readStream($fileName);
        
                return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                    fpassthru($stream);
                }, 200, [
                    'Content-Type'        => $fs->getMimetype($fileName),
                    'Content-Length'      => $fs->getSize($fileName),
                    'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
                ]);
                //
            }
            abort(404);
        }
        if (isset($diskName) && Storage::disk($diskName)
                ->exists($fileName)) {
            $diskAdapter = Storage::disk($diskName)
                ->getAdapter();
            $diskType    = class_basename($diskAdapter);
            switch ($diskType) {
                case 'SftpAdapter' :
                    if (isset($file)) {
                        $url = $file->getUrl();
                        if (isset($url[0])) {
                            return response()->redirectTo($url);
                        }
                    
                        $fs     = Storage::disk($diskName)
                            ->getDriver();
                        $stream = $fs->readStream($fileName);
                    
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            'Content-Type'        => $fs->getMimetype($fileName),
                            'Content-Length'      => $fs->getSize($fileName),
                            'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
                        ]);
                    }
                
                    break;
                case 'Local' :
                    $fs     = Storage::disk($diskName)
                        ->getDriver();
                    $stream = $fs->readStream($fileName);
                
                    return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                        fpassthru($stream);
                    }, 200, [
                        'Content-Type'        => $fs->getMimetype($fileName),
                        'Content-Length'      => $fs->getSize($fileName),
                        'Content-disposition' => 'attachment; filename="'.basename($fileName).'"',
                    ]);
                    break;
                default:
                    break;
            
            }
            abort(404);
        }
        if (isset($externalLink)) {
            return redirect($externalLink);
        }
        abort(404);

    }
    
    /**
     * @param $products
     *
     * @return string
     */
    private function getMessageThatShouldByWhichProducts($products): string
    {
        $message    = 'شما ابتدا باید یکی از این محصولات را سفارش دهید و یا اگر سفارش داده اید مبلغ را تسویه نمایید: '.'<br>';
        $productIds = [];
        /** @var Product $product */
        foreach ($products as $product) {
            $myParents = $product->getAllParents();
            if ($myParents->isNotEmpty()) {
                $rootParent = $myParents->last();
                if (!in_array($rootParent->id, $productIds)) {
                    $message .= '<a href="'.action('ProductController@show',
                            $rootParent->id).'">'.$rootParent->name.'</a><br>';
                    array_push($productIds, $rootParent->id);
                }
            } else {
                if (!in_array($product->id, $productIds)) {
                    $message .= '<a href="'.action('ProductController@show',
                            $product->id).'">'.$product->name.'</a><br>';
                    array_push($productIds, $product->id);
                }
            }
        }
        return $message;
    }
    
    /**
     * Show the general error page.
     *
     * @param  string  $message
     *
     * @return Response
     */
    public function errorPage($message)
    {
        //        $message = Input::get("message");
        if (strlen($message) <= 0) {
            $message = '';
        }
    
        return view('errors.errorPage', compact('message'));
    }
    
    public function getImage($category, $w, $h, $fileName)
    {
        switch ($category) {
            case '1';
                $diskName = config('constants.DISK1');
                break;
            case '4':
                $diskName = config('constants.DISK4');
                break;
            case '7':
                $diskName = config('constants.DISK7');
                break;
            case '8':
                $diskName = config('constants.DISK8');
                break;
            case '9':
                $diskName = config('constants.DISK9');
                break;
            case '11':
                $diskName = config('constants.DISK11');
                break;
            default:
                break;
        }
        if (Storage::disk($diskName)
            ->exists($fileName)) {
            $file         = Storage::disk($diskName)
                ->get($fileName);
            $type         = Storage::disk($diskName)
                ->mimeType($fileName);
            $etag         = md5($file);
            $lastModified = Storage::disk($diskName)
                ->lastModified($fileName);
            $size         = strlen($file);
            
            return response($file, 200)
                ->header('Content-Type', $type)
                ->header('Content-Length',
                    $size)
                ->setMaxAge(3600)
                ->setPublic()
                ->setEtag($etag)
                ->setLastModified(Carbon::createFromTimestamp($lastModified));
        }
        
        return redirect(action("Web\HomeController@error404"));
    }
    
    function siteMapXML()
    {
        return redirect(action('Web\SitemapController@index'), 301);
    }
    
    /**
     * Sends an email to the website's own email
     *
     * @param  \app\Http\Requests\ContactUsFormRequest  $request
     *
     * @return Response
     */
    public function sendMail(ContactUsFormRequest $request)
    {
        $wSetting = $this->setting;
        
        //        try {
        //            $sent = Mail::send('emailLayouts.contactUs',
        //                array(
        //                    'name' =>  $request->get('fullName'),
        //                    'email' => $request->get('email'),
        //                    'phone' =>  $request->get('phone'),
        //                    'comment' => $request->get('message')
        //                ), function($message) use ($request , $wSetting)
        //                {
        //                    if(isset($wSetting->branches->main->emails[0]->address)) $to = $wSetting->branches->main->emails[0]->address;
        //                    else $to = "";
        ////                    $to = "mohamad.shahrokhi@gmail.com";
        //                    $message->from('info@itecsgroup.com');
        //                    $message->to($to, 'itecsgroup.com')->subject('تماس با ما');
        //                    $email =$request->get("email");
        //                    if(strlen($email)>0)  $message->replyTo($request->get('email'), $request->get('fullName'));
        //                });
        //
        //            if($sent)
        //            {
        //                session()->flash('success', 'پیام با موفقیت ارسال شد');
        //                return redirect()->back();
        //            }else
        //            {
        //                session()->flash('error', 'خطا در ارسال پیام ، لطفا دوباره اقدام نمایید');
        //                return redirect()->back();
        //            }
        //        } catch ( \Exception    $error) {
        //            $message = "با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید";
        //            return $this->errorPage($message) ;
        //        }
        
        $email   = $request->get('email');
        $name    = $request->get('fullName');
        $phone   = $request->get('phone');
        $comment = $request->get('message');
        
        //create a boundary for the email. This
        $boundary = uniqid('sh');
        
        // multiple recipients
        //    $to  = 'info@sanatisharif.ir' . ', '; // note the comma
        //    $to .= 'foratmail@gmail.com';
        
        if (isset($wSetting->branches->main->emails[0]->address)) {
            $to = $wSetting->branches->main->emails[0]->address;
        } else {
            $to = '';
        }
        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-Type: multipart/alternative; boundary="'.$boundary."\"\r\n";//';charset=UTF-8' .
        $headers .= 'From: '.strip_tags(config('constants.MAIL_USERNAME'))."\r\n".'Reply-To: '.strip_tags($email)."\r\n".'X-Mailer: PHP/'.phpversion();
        
        $orginaltext = $request->get('message');
        
        $orginaltext = str_replace('\"', '"', $orginaltext);
        $orginaltext = str_replace('\\\\', '\\', $orginaltext);
        
        $sender = '<p dir="rtl"> نام فرستنده: '.$name.'</p>';
        if (strlen($email) > 0) {
            $sender .= '<p dir="rtl"> ایمیل فرستنده: '.$email.'</p>';
        }
        if (strlen($phone) > 0) {
            $sender .= '<p dir="rtl">  شماره تماس فرستنده: '.$phone.'</p>';
        }
        
        //plainText version
        $text = "\r\n\r\n--".$boundary."\r\n"; //header
        $text .= "Content-type: text/plain; charset=utf-8 \r\n\r\n"; //header
        
        $text .= strip_tags($orginaltext)."\r\n".strip_tags($sender);
        
        //htmlText version
        
        $text .= "\r\n\r\n--".$boundary."\r\n"; //header
        $text .= "Content-type: text/html; charset=utf-8 \r\n\r\n"; //header
        
        //            $text .= $sender.str_replace('\"','\'','<p dir="rtl" style="text-align: right">'.$orginaltext.'</p>') ;
        $text .= view('emailLayouts.contactUs', compact('email', 'phone', 'comment', 'name'));
        
        /*$text .='
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><h1>'.$subject.'</h1></title>
            </head>
            <body dir="rtl">
                '.$orginaltext.'\r\n'.$sender.'
            </body>
        </html>
            ';*/
    
        $text .= "\r\n\r\n--".$boundary.'--';
    
        $subject = 'آلاء - تماس با ما';
        
        try {
            $numSent = mail($to, $subject, $text, $headers);
            if ($numSent) {
                session()->put('success', 'پیام با موفقیت ارسال شد');
                
                return redirect()->back();
            } else {
                session()->put('error', 'خطا در ارسال پیام ، لطفا دوباره اقدام نمایید');
                
                return redirect()->back();
            }
        } catch (Exception    $error) {
            $message = 'با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید';
            
            return $this->errorPage($message);
        }
    }
    
    /**
     * Send a custom SMS to the user
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function sendSMS(Request $request)
    {
        $from      = $request->get('smsProviderNumber');
        $message   = $request->get('message');
        $usersId   = $request->get('users');
        $usersId   = explode(',', $usersId);
        $relatives = $request->get('relatives');
        $relatives = explode(',', $relatives);
        
        $smsNumber = config('constants.SMS_PROVIDER_DEFAULT_NUMBER');
        $users     = User::whereIn('id', $usersId)
            ->get();
        if ($users->isEmpty()) {
            return $this->response->setStatusCode(451);
        }
        
        if (!isset($from) || strlen($from) == 0) {
            $from = $smsNumber;
        }
        
        $mobiles    = [];
        $finalUsers = collect();
        foreach ($users as $user) {
            if (in_array(0, $relatives)) {
                array_push($mobiles, ltrim($user->mobile, '0'));
            }
            if (in_array(1, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $fatherMobiles = $user->contacts->where('relative_id', 1)
                        ->first()->phones->where('phonetype_id', 1)
                        ->sortBy('priority');
                    if (!$fatherMobiles->isEmpty()) {
                        foreach ($fatherMobiles as $fatherMobile) {
                            array_push($mobiles, ltrim($fatherMobile->phoneNumber, '0'));
                        }
                    }
                }
            }
            if (in_array(2, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $motherMobiles = $user->contacts->where('relative_id', 2)
                        ->first()->phones->where('phonetype_id', 1)
                        ->sortBy('priority');
                    if (!$motherMobiles->isEmpty()) {
                        foreach ($motherMobiles as $motherMobile) {
                            array_push($mobiles, ltrim($motherMobile->phoneNumber, '0'));
                        }
                    }
                }
            }
        }
        $smsInfo            = [];
        $smsInfo['message'] = $message;
        $smsInfo['to']      = $mobiles;
        $smsInfo['from']    = $from;
        $response           = $this->medianaSendSMS($smsInfo);
        //Sending notification to user collection
//        Notification::send($users, new GeneralNotice($message));
        if (!$response['error']) {
            $smsCredit = $this->medianaGetCredit();
            
            return $this->response->setContent($smsCredit)
                ->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }
    
    /**
     * Sends an email to the website's own email
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return Response
     */
    public function uploadFile(\Illuminate\Http\Request $request)
    {
    
        $filePath         = $request->header('X-File-Name');
        $originalFileName = $request->header('X-Dataname');
        $filePrefix       = '';
        $contentSetId     = $request->header('X-Dataid');
        $disk             = $request->header('X-Datatype');
        $done             = false;
        
        //        dd($request->headers->all());
        try {
            $dirname  = pathinfo($filePath, PATHINFO_DIRNAME);
            $ext      = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $fileName = basename($originalFileName, '.'.$ext).'_'.date('YmdHis').'.'.$ext;
            
            $newFileNameDir = $dirname.'/'.$fileName;
            
            //            dd([
            //                "filePath"=>$filePath,
            //                "newFileNameDir"=>$newFileNameDir
            //            ]);
            if (File::exists($newFileNameDir)) {
                File::delete($newFileNameDir);
            }
            File::move($filePath, $newFileNameDir);
    
            if (strcmp($disk, 'product') == 0) {
                if ($ext == 'mp4') {
                    $directory = 'video';
                } else {
                    if ($ext == 'pdf') {
                        $directory = 'pamphlet';
                    }
                }
                
                $adapter    = new SftpAdapter([
                    'host'          => config('constants.SFTP_HOST'),
                    'port'          => config('constants.SFTP_PORT'),
                    'username'      => config('constants.SFTP_USERNAME'),
                    'password'      => config('constants.SFTP_PASSSWORD'),
                    'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                    'root'          => config('constants.SFTP_ROOT').'/private/'.$contentSetId.'/',
                    'timeout'       => config('constants.SFTP_TIMEOUT'),
                    'directoryPerm' => 0755,
                ]);
                $filesystem = new Filesystem($adapter);
                if (isset($directory)) {
                    if (!$filesystem->has($directory)) {
                        $filesystem->createDir($directory);
                    }
    
                    $filePrefix = $directory.'/';
                    $filesystem = $filesystem->get($directory);
                    $path       = $filesystem->getPath();
                    $filesystem->setPath($path.'/'.$fileName);
                    if ($filesystem->put(fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                } else {
                    if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                }
            } else {
                if (strcmp($disk, 'video') == 0) {
                    $adapter    = new SftpAdapter([
                        'host'          => config('constants.SFTP_HOST'),
                        'port'          => config('constants.SFTP_PORT'),
                        'username'      => config('constants.SFTP_USERNAME'),
                        'password'      => config('constants.SFTP_PASSSWORD'),
                        'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                        // example:  /alaa_media/cdn/media/203/HD_720p , /alaa_media/cdn/media/thumbnails/203/
                        'root'          => config('constants.DOWNLOAD_SERVER_ROOT').config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH').$contentSetId,
                        'timeout'       => config('constants.SFTP_TIMEOUT'),
                        'directoryPerm' => 0755,
                    ]);
                    $filesystem = new Filesystem($adapter);
                    if ($filesystem->put($originalFileName, fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                        // example:  https://cdn.sanatisharif.ir/media/203/hq/203001dtgr.mp4
                        $fileName = config('constants.DOWNLOAD_SERVER_PROTOCOL').config('constants.DOWNLOAD_SERVER_NAME').config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH').$contentSetId.$originalFileName;
                    }
                } else {
                    $filesystem = Storage::disk($disk.'Sftp');
                    //                Storage::putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
                    if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                }
            }
            if ($done) {
                return $this->response->setStatusCode(Response::HTTP_OK)
                    ->setContent([
                        'fileName' => $fileName,
                        'prefix'   => $filePrefix,
                    ]);
            } else {
                return $this->response->setStatusCode(503);
            }
        } catch (Exception $e) {
            //            return $this->TAG.' '.$e->getMessage();
            $message = 'unexpected error';
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    'message' => $message,
                    'error'   => $e->getMessage(),
                    'line'    => $e->getLine(),
                    'file'    => $e->getFile(),
                ]);
        }
    }
    //    public function certificates()
    //    {
    //        return view("pages.certificates");
    //    }
    
    
    public function convertArray(array $input)
    {
        foreach ($input as $key => $value) {
            $input[$key] = $this->convert($value);
        }
        
        return $input;
    }
    
    /**
     * @param $result
     *
     * @return string
     */
    public function convert($result): string
    {
        return iconv(mb_detect_encoding($result, mb_detect_order(), true), 'UTF-8', $result);
        //         return iconv('windows-1250', 'utf-8', $result) ;
        //        return chr(255) . chr(254).mb_convert_encoding($result, 'UTF-16LE', 'UTF-8');
        //        return utf8_encode($result);
    }

    
    /**
     * Showing create form for user's kunkoor result
     *
     * @return Response
     */
    public function submitKonkurResult(Request $request)
    {
    
        $majors      = Major::where('majortype_id', 1)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
        $majors      = array_add($majors, 0, 'انتخاب رشته');
        $majors      = array_sort_recursive($majors);
        $event       = Event::where('name', 'konkur97')
            ->first();
        $sideBarMode = 'closed';
    
        $userEventReport = Eventresult::where('user_id', Auth::user()->id)
            ->where('event_id', $event->id)
            ->get()
            ->first();
    
        $pageName       = 'submitKonkurResult';
        $user           = Auth::user();
        $userCompletion = (int) $user->completion();
        $url            = $request->url();
        $title          = 'آلاء|کارنامه سراسری 97';
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite('آلاء');
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()
            ->addImage(route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), [
                'height' => 100,
                'width'  => 100,
            ]);
    
        return view('user.submitEventResultReport',
            compact('majors', 'event', 'sideBarMode', 'userEventReport', 'pageName', 'user', 'userCompletion'));
    }
    
    public function schoolRegisterLanding(Request $request)
    {
        abort(404);
        $eventRegistered = false;
        if (Auth::check()) {
            $user  = Auth::user();
            $event = Event::where('name', 'sabtename_sharif_97')
                ->get();
            if ($event->isEmpty()) {
                dd('ثبت نام آغاز نشده است');
            } else {
                $event           = $event->first();
                $events          = $user->eventresults->where('user_id', $user->id)
                    ->where('event_id', $event->id);
                $eventRegistered = $events->isNotEmpty();
                if ($eventRegistered) {
                    $score = $events->first()->participationCodeHash;
                }
                if (isset($user->firstName) && strlen(preg_replace('/\s+/', '', $user->firstName)) > 0) {
                    $firstName = $user->firstName;
                }
                if (isset($user->lastName) && strlen(preg_replace('/\s+/', '', $user->lastName)) > 0) {
                    $lastName = $user->lastName;
                }
                if (isset($user->mobile) && strlen(preg_replace('/\s+/', '', $user->mobile)) > 0) {
                    $mobile = $user->mobile;
                }
                if (isset($user->nationalCode) && strlen(preg_replace('/\s+/', '', $user->nationalCode)) > 0) {
                    $nationalCode = $user->nationalCode;
                }
                $major = $user->major_id;
                $grade = $user->grade_id;
            }
        }
        $url   = $request->url();
        $title = $this->setting->site->seo->homepage->metaTitle;
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite('آلاء');
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()
            ->addImage(route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), [
                'height' => 100,
                'width'  => 100,
            ]);
        $pageName = 'schoolRegisterLanding';
    
        return view('pages.schoolRegister',
            compact('pageName', 'user', 'major', 'grade', 'firstName', 'lastName', 'mobile', 'nationalCode', 'score',
                'eventRegistered'));
    }

    /**
     * @param  Request  $request
     *
     * @return
     */
    public function lernitoTree(Request $request)
    {
        $Riazi   = new Riazi();
        $Tajrobi = new Tajrobi();
        $Ensani  = new Ensani();
        
        $lastUpdatedByLernito = $this->getLastUpdatedByLernito();
        
        /*return $lastUpdatedByLernito;*/
        
        $mote2 = [
            [
                'id'       => '6321',
                'text'     => 'ریاضی و فیزیک',
                'tags'     => json_encode(['ریاضی_و_فیزیک'], JSON_UNESCAPED_UNICODE),
                'children' => $Riazi->getLernitoStyle(),
            ],
            [
                'id'       => '11552',
                'text'     => 'علوم تجربی',
                'tags'     => json_encode(['علوم_تجربی'], JSON_UNESCAPED_UNICODE),
                'children' => $Tajrobi->getLernitoStyle(),
            ],
            [
                'id'       => '15896',
                'text'     => 'علوم انسانی',
                'tags'     => json_encode(['علوم_انسانی'], JSON_UNESCAPED_UNICODE),
                'children' => $Ensani->getLernitoStyle(),
            ],
        ];
        /*return $mote2;*/
        
        $htmlPrint    = '';
        $treePathData = [];
        // loop in reshte
        $htmlPrint .= '<ul>';
        foreach ($mote2 as $key => $value) {
            $pathString1 = $value['text'];
            $pathId1     = $value['id'];
            
            $lastUpdatedByLernitoKey = '';
            if ($key == 0) {
                $lastUpdatedByLernitoKey = 'riaziUpdate';
            } else {
                if ($key == 1) {
                    $lastUpdatedByLernitoKey = 'tajrobiUpdate';
                } else {
                    if ($key == 2) {
                        $lastUpdatedByLernitoKey = 'ensaniUpdate';
                    }
                }
            }
            
            if (isset($lastUpdatedByLernito[$lastUpdatedByLernitoKey]) && count($lastUpdatedByLernito[$lastUpdatedByLernitoKey]['diff']) > 0) {
                $value['hasNewItem'] = true;
                $this->updatePaieNodes($lastUpdatedByLernito[$lastUpdatedByLernitoKey], $value['children']);
            }
            
            $hasNew = '0';
            if (isset($value['hasNewItem']) && $value['hasNewItem'] === true) {
                $hasNew = '1';
            }
            $htmlPrint .= '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-alaa-node-id="'.$value['id'].'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>رشته: "'.$value['text'];
            
            // loop in paie
            $htmlPrint .= '<ul>';
            foreach ($value['children'] as $key1 => $value1) {
                $pathString2 = $pathString1.'@@**@@'.$value1['name'];
                $pathId2     = $pathId1.'-'.$value1['id'];
                
                $hasNew = '0';
                if (isset($value1['hasNewItem']) && $value1['hasNewItem'] === true) {
                    $hasNew = '1';
                }
                $isNew = '0';
                if (isset($value1['isNewItem']) && $value1['isNewItem'] === true) {
                    $isNew = '1';
                }
                
                $htmlPrint .= '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-is-new="'.$isNew.'" data-alaa-node-id="'.$value1['id'].'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>پایه: '.$value1['name'];
                
                // loop in dars
                $htmlPrint .= '<ul>';
                foreach ($value1['children'] as $key2 => $value2) {
                    $pathString3 = $pathString2.'@@**@@'.$value2['name'];
                    $pathId3     = $pathId2.'-'.$value2['id'];
                    $htmlPrint   .= $this->printDars($value2, $pathString3, $pathId3);
                }
                $htmlPrint .= '</ul></li>';
            }
            $htmlPrint .= '</ul></li>';
        }
        $htmlPrint .= '</ul>';
        
        return view('admin.topicsTree.index', compact('mote2', 'treePathData', 'htmlPrint', 'lastUpdatedByLernito'));
    }

    private function getLastUpdatedByLernito(): array
    {
        $Riazi                = new Riazi();
        $Tajrobi              = new Tajrobi();
        $Ensani               = new Ensani();
        $lastUpdatedByLernito = [
            'riaziUpdate'   => [
                'diff'     => $Riazi->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id'   => '6321',
                    'text' => 'ریاضی و فیزیک',
                    'tags' => json_encode(['ریاضی_و_فیزیک'], JSON_UNESCAPED_UNICODE),
                ],
            ],
            'tajrobiUpdate' => [
                'diff'     => $Tajrobi->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id'   => '11552',
                    'text' => 'علوم تجربی',
                    'tags' => json_encode(['علوم_تجربی'], JSON_UNESCAPED_UNICODE),
                ],
            ],
            'ensaniUpdate'  => [
                'diff'     => $Ensani->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id'   => '15896',
                    'text' => 'علوم انسانی',
                    'tags' => json_encode(['علوم_انسانی'], JSON_UNESCAPED_UNICODE),
                ],
            ],
        ];
        
        return $lastUpdatedByLernito;
    }
    
    private function updatePaieNodes(array $lastUpdatedByLernito, &$oldChildren)
    {
        if (isset($lastUpdatedByLernito['diff'])) {
            foreach ($lastUpdatedByLernito['diff'] as $diffKey => $diffNode) {
                if (!isset($diffNode['diff']) && isset($diffNode['lernitoNode'])) {
                    $newItem              = $this->changeLernitoNodeToAlaaNode($diffNode['lernitoNode']);
                    $newItem['isNewItem'] = true;
                    $oldChildren[]        = $newItem;
                } else {
                    if (isset($diffNode['diff']) && isset($diffNode['lernitoNode']) && isset($diffNode['alaaNode'])) {
                        foreach ($oldChildren as $oldChildrenKey => $oldChildrenValue) {
                            if ($diffNode['alaaNode']['id'] == $oldChildrenValue['id']) {
                                $oldChildren[$oldChildrenKey]['hasNewItem'] = true;
                                $this->updatePaieNodes($diffNode, $oldChildren[$oldChildrenKey]['children']);
                            }
                        }
                    }
                }
            }
        }
    }
    
    private function changeLernitoNodeToAlaaNode(array &$lernitoNode)
    {
        $this->changeLernitoNodeChildren($lernitoNode);
        
        return $lernitoNode;
    }
    
    private function changeLernitoNodeChildren(array &$lernitoNodeChildren)
    {
        $lernitoNodeChildren['id']   = time().'-'.$lernitoNodeChildren['_id'];
        $lernitoNodeChildren['name'] = $lernitoNodeChildren['label'];
        $lernitoNodeChildren['tags'] = json_encode([str_replace(' ', '_', $lernitoNodeChildren['label'])],
            JSON_UNESCAPED_UNICODE);
        unset($lernitoNodeChildren['_id']);
        unset($lernitoNodeChildren['label']);
        if (isset($lernitoNodeChildren['children'])) {
            foreach ($lernitoNodeChildren['children'] as $key => $child) {
                $this->changeLernitoNodeChildren($lernitoNodeChildren['children'][$key]);
            }
        }
    }
    
    private function printDars(array $nodeData, string $ps, string $pid)
    {
        global $treePathData;
        
        $name = 'درس: '.$nodeData['name'];
        $data = $nodeData['children'];
        $id   = $nodeData['id'];
        
        $hasNew = '0';
        if (isset($nodeData['hasNewItem']) && $nodeData['hasNewItem'] === true) {
            $hasNew = '1';
        }
        $isNew = '0';
        if (isset($nodeData['isNewItem']) && $nodeData['isNewItem'] === true) {
            $isNew = '1';
        }
        
        $htmlPrint = '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-is-new="'.$isNew.'" data-alaa-node-id="'.$id.'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>'.$name.'<ul>';
        foreach ($data as $key => $value) {
            $pathString = $ps.'@@**@@'.$value['name'];
            $pathId     = $pid.'-'.$value['id'];
            
            if (isset($value['children']) && count($value['children']) > 0) {
                //                $htmlPrint .= '<li>('.$value['name'].')'.$this->printDars($value['name'], $value['children'], $value['id'], $pathString, $pathId).'</li>';
                $htmlPrint .= $this->printDars($value, $pathString, $pathId);
            } else {
                
                $isNewItem = '0';
                if (isset($value['isNewItem']) && $value['isNewItem'] === true) {
                    $isNewItem = '1';
                }
                
                $htmlPrint                  .= '<li data-jstree=\'{"icon":"/acm/extra/topicsTree/img/book-icon-1.png"}\' data-alaa-node-id="'.$value['id'].'" data-is-new="'.$isNewItem.'" ps="'.$pathString.'" pid="'.$pathId.'" id="'.$value['id'].'">'.$value['name'].'</li>';
                $treePathData[$value['id']] = [
                    'ps'  => $pathString,
                    'pid' => $pathId,
                ];
            }
        }
        $htmlPrint .= '</ul></li>';
        
        return $htmlPrint;
    }
    
    public function getTreeInPHPArrayString(Request $request, $lnid)
    {
        if (!is_numeric($lnid)) {
            return '';
        }
        $lernitoNodeId        = $lnid;
        $lastUpdatedByLernito = $this->getLastUpdatedByLernito();
        $maxId                = $this->getLastIdOfTopicsTree();
        
        $nodeFound = $this->findLernitoNodeById($lastUpdatedByLernito, $lernitoNodeId);
        $this->changeLernitoNodeToAlaaNode($nodeFound);
        $stringFormat = str_replace('"', "'", $this->convertAlaaNodeArrayToStringFormat($nodeFound, $maxId));
        $stringFormat = str_replace(PHP_EOL, '', $stringFormat);
        
        return $stringFormat;
    }
    
    private function getLastIdOfTopicsTree(): int
    {
        $maxId     = 0;
        $totalTree = $this->getTotalTopicsTree();
        $maxId     = $this->iterateThroughTotalTree($totalTree);
        
        return $maxId;
    }
    
    private function getTotalTopicsTree(): array
    {
        $Riazi     = new Riazi();
        $Tajrobi   = new Tajrobi();
        $Ensani    = new Ensani();
        $totalTree = array_merge($Riazi->getTree(), $Tajrobi->getTree(), $Ensani->getTree());
        
        return $totalTree;
    }
    
    private function iterateThroughTotalTree($tree)
    {
        $maxId = 0;
        if (isset($tree['id'])) {
            $tree['id'] = (int) $tree['id'];
            if ($tree['id'] > $maxId) {
                $maxId = $tree['id'];
            }
            if (isset($tree['children']) && count($tree['children']) > 0) {
                $newMaxId = $this->iterateThroughTotalTree($tree['children']);
                if ($newMaxId > $maxId) {
                    $maxId = $newMaxId;
                }
            }
        } else {
            foreach ($tree as $key => $value) {
                if (isset($value['id'])) {
                    $value['id'] = (int) $value['id'];
                }
                if (isset($value['id']) && $value['id'] > $maxId) {
                    $maxId = $value['id'];
                }
                if (isset($value['children']) && count($value['children']) > 0) {
                    $newMaxId = $this->iterateThroughTotalTree($value['children']);
                    if ($newMaxId > $maxId) {
                        $maxId = $newMaxId;
                    }
                }
            }
        }
        
        return $maxId;
    }
    
    private function findLernitoNodeById(array $lastUpdatedByLernito, int $lernitoNodeId)
    {
        $nodeFound = null;
        foreach ($lastUpdatedByLernito as $key => $value) {
            if (isset($value['lernitoNode']['_id']) && $value['lernitoNode']['_id'] == $lernitoNodeId) {
                return $value['lernitoNode'];
            } else {
                if (isset($value['diff'])) {
                    $nodeFound = $this->findLernitoNodeById($value['diff'], $lernitoNodeId);
                    if ($nodeFound != null) {
                        return $nodeFound;
                    }
                }
            }
        }
        
        return $nodeFound;
    }
    
    private function convertAlaaNodeArrayToStringFormat(array $alaaNode, &$nodeId): string
    {
        
        if (isset($alaaNode['name'])) {
            $nodeId++;
            $nodeArrayString = "
            <div class='objectWraper'>
                <div>[</div>";
            $nodeArrayString .= "
                    <div class='objectBody'>
                        <div>'id' => '$nodeId',</div>
                        <div>'name' => '".$alaaNode['name']."',</div>
                        <div>'tags' => ".json_encode([str_replace(' ', '_', $alaaNode['name'])],
                    JSON_UNESCAPED_UNICODE).",</div>
                        <div>'children' => ".$this->convertAlaaNodeArrayToStringFormat((isset($alaaNode['children'])) ? $alaaNode['children'] : [],
                    $nodeId).'</div>
                    </div>';
            $nodeArrayString .= '
                <div>]</div>
            </div>';
        } else {
            $nodeArrayString = '[';
            foreach ($alaaNode as $key => $value) {
                $nodeId++;
                $nodeArrayString .= "
                    <div class='inChildren'>
                        <div>[</div>";
                $nodeArrayString .= "
                            <div class='objectBody'>
                                <div>'id' => '$nodeId',</div>
                                <div>'name' => '".$value['name']."',</div>
                                <div>'tags' => ".json_encode([str_replace(' ', '_', $value['name'])],
                        JSON_UNESCAPED_UNICODE).",</div>
                                <div>'children' => ".$this->convertAlaaNodeArrayToStringFormat((isset($value['children'])) ? $value['children'] : [],
                        $nodeId).'</div>
                            </div>';
                $nodeArrayString .= '
                        <div>],</div>
                    </div>';
            }
            if (count($alaaNode) > 0) {
                $nodeArrayString .= '
                    <div>]</div>';
            } else {
                $nodeArrayString .= ']';
            }
        }
        
        return $nodeArrayString;
    }
}
