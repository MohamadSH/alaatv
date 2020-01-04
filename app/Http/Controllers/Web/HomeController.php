<?php

namespace App\Http\Controllers\Web;

use App\{Classes\Repository\ContentRepositoryInterface,
    Classes\Repository\ProductRepository as ProductRepository,
    Http\Requests\ContactUsFormRequest,
    Http\Requests\Request,
    Notifications\sendLink,
    Product,
    Productfile,
    Traits\APIRequestCommon,
    Traits\CharacterCommon,
    Traits\Helper,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Traits\UserCommon,
    UploadCenter,
    User,
    Websitesetting};
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\{Config, File, Storage};

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

    private $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->setting = $setting->setting;

        $authException = [
//            'debug',
            'newDownload',
            'download',
            'getImage',
            'sendMail',
            'siteMapXML',
            'search',
            'home',
        ];
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('role:admin', ['only' => ['debug']]);
        $this->middleware('permission:' . config('constants.UPLOAD_CENTER_ACCESS'), ['only' => 'uploadCenter']);
        $this->middleware('permission:' . config('constants.UPLOAD_CENTER_ACCESS'), ['only' => 'upload']);
        $this->middleware('permission:' . config('constants.UPLOAD_CENTER_ACCESS'), ['only' => 'bigUpload']);
        $this->middleware('permission:' . config('constants.SEND_SMS_TO_USER_ACCESS'), ['only' => 'smsLink']);
    }

    public function debug(Request $request, User $user = null)
    {
        $user = User::Find(1);
        return $user;
        return view('admin.topicsTree.manageNodes');
    }

    public function search(Request $request)
    {
        return redirect(action("Web\ContentController@index"), Response::HTTP_MOVED_PERMANENTLY);
    }

    public function home()
    {
        return redirect('/', Response::HTTP_MOVED_PERMANENTLY);
    }

    /**
     * @param Request                                              $request
     * @param                                                      $data
     *
     * @param ContentRepositoryInterface                           $contentRepository
     *
     * @return RedirectResponse|Redirector
     */
    public function newDownload(Request $request, $data, ContentRepositoryInterface $contentRepository)
    {
        /** @var User $user */
        $user = $request->user('alaatv');
        if ($user === null) {
            abort(Response::HTTP_FORBIDDEN, 'Not authorized.');
        }
        if ($data === null) {
            abort(Response::HTTP_FORBIDDEN, 'Invalid Link');
        }
        try {
            $data = (array)decrypt($data);
        } catch (DecryptException $e) {
            abort(Response::HTTP_FORBIDDEN, 'invalid Data!');
        }
        $url       = $data['url'];
        $contentId = $data['data']['content_id'];
        $content   = $contentRepository->getContentById($contentId);
        if (!$user->hasContent($content)) {
            return redirect()
                ->action('Web\ContentController@show', $content)
                ->setStatusCode(Response::HTTP_FOUND);
        }
        $finalLink = $this->getSecureUrl($url, $request);

        return redirect($finalLink);
    }

    /**
     * @param         $url
     *
     * @param Request $request
     *
     * @return string
     */
    private function getSecureUrl($url, Request $request): string
    {
        $download = $request->get('download', null);

        $unixTime = Carbon::today()
            ->addDays(2)->timestamp;
        $userIP   = request()->ip();
        //TODO: fix diffrent Ip
        $ipArray    = explode('.', $userIP);
        $ipArray[3] = 0;
        $userIP     = implode('.', $ipArray);

        $linkHash  = $this->generateSecurePathHash($unixTime, $userIP, 'TakhteKhak', $url);
        $finalLink = $url . '?md5=' . $linkHash . '&expires=' . $unixTime;
        if (isset($download)) {
            $finalLink .= '&download=1';
        }
        return $finalLink;
    }

    public function download(Request $request, ErrorPageController $errorPageController)
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

                //if(!Auth::user()->permissions->contains(Permission::all()->where("name", config('constants.DOWNLOAD_ASSIGNMENT_ACCESS'))->first()->id)) return redirect(action(("ErrorPageController@error403"))) ;
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
                $productId = $request->get('pId');
                $diskName  = config('constants.DISK13');

                if (isset($user) && !$user->can(config('constants.DOWNLOAD_PRODUCT_FILE'))) {
                    $products    =
                        ProductRepository::getProductsThatHaveValidProductFileByFileNameRecursively($fileName);
                    $validOrders = $user->getOrdersThatHaveSpecificProduct($products);

                    if (!$products->isEmpty()) {
                        if (!$validOrders->isEmpty()) {
                            $productId = (array)$productId;
                            if (isset($products)) {
                                $productId = array_merge($productId, $products->pluck('id')
                                    ->toArray());
                            }
                            $externalLink = (new Productfile)->getExternalLinkForProductFileByFileName($fileName,
                                $productId);
                            break;
                        }
                        $message = $this->getMessageThatShouldByWhichProducts($products);
                        return $errorPageController->errorPage($message);
                    }
                    $message = 'چنین فایلی وجود ندارد ویا غیر فعال شده است';
                    return $errorPageController->errorPage($message);
                }
                break;
            case 'فایل کارنامه' :
                $diskName = config('constants.DISK14');
                break;
            case config('constants.DISK18') :
                if (Storage::disk(config('constants.DISK18_CLOUD'))->exists($fileName)) {
                    $diskName = config('constants.DISK18_CLOUD');
                } else {
                    $diskName = config('constants.DISK18');
                }
                break;
            case config('constants.DISK19'):
                if (Storage::disk(config('constants.DISK19_CLOUD2'))->exists($fileName)) {
                    $diskName = Config::  get('constants.DISK19_CLOUD2');
                } else {
                    $diskName = config('constants.DISK19');
                }
                break;
            case config('constants.DISK20'):
                if (Storage::disk(config('constants.DISK20_CLOUD'))->exists($fileName)) {
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
                    abort(Response::HTTP_NOT_FOUND);
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
                    }, Response::HTTP_OK, [
                        'Content-Type'        => $fs->getMimetype($fileName),
                        'Content-Length'      => $fs->getSize($fileName),
                        'Content-disposition' => 'attachment; filename="' . basename($fileName) . '"',
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

                    $fileRemotePath =
                        config('constants.DOWNLOAD_SERVER_PROTOCOL') . config('constants.PAID_SERVER_NAME') . '/public' . explode('public',
                            $fileRoot)[1];

                    return response()->redirectTo($fileRemotePath . $fileName);
                }

                $fs     = Storage::disk($diskName)
                    ->getDriver();
                $stream = $fs->readStream($fileName);

                return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                    fpassthru($stream);
                }, Response::HTTP_OK, [
                    'Content-Type'        => $fs->getMimetype($fileName),
                    'Content-Length'      => $fs->getSize($fileName),
                    'Content-disposition' => 'attachment; filename="' . basename($fileName) . '"',
                ]);
                //
            }
            abort(Response::HTTP_NOT_FOUND);
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
                        }, Response::HTTP_OK, [
                            'Content-Type'        => $fs->getMimetype($fileName),
                            'Content-Length'      => $fs->getSize($fileName),
                            'Content-disposition' => 'attachment; filename="' . basename($fileName) . '"',
                        ]);
                    }

                    break;
                case 'Local' :
                    $fs     = Storage::disk($diskName)
                        ->getDriver();
                    $stream = $fs->readStream($fileName);

                    return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                        fpassthru($stream);
                    }, Response::HTTP_OK, [
                        'Content-Type'        => $fs->getMimetype($fileName),
                        'Content-Length'      => $fs->getSize($fileName),
                        'Content-disposition' => 'attachment; filename="' . basename($fileName) . '"',
                    ]);
                    break;
                default:
                    break;

            }
            abort(Response::HTTP_NOT_FOUND);
        }
        if (isset($externalLink)) {
            return redirect($externalLink);
        }
        abort(Response::HTTP_NOT_FOUND);

    }

    /**
     * @param $products
     *
     * @return string
     */
    private function getMessageThatShouldByWhichProducts($products): string
    {
        $message    =
            'شما ابتدا باید یکی از این محصولات را سفارش دهید و یا اگر سفارش داده اید مبلغ را تسویه نمایید: ' . '<br>';
        $productIds = [];
        /** @var Product $product */
        foreach ($products as $product) {
            $myParents = $product->getAllParents();
            if ($myParents->isNotEmpty()) {
                $rootParent = $myParents->last();
                if (!in_array($rootParent->id, $productIds)) {
                    $message .= '<a href="' . action('ProductController@show',
                            $rootParent->id) . '">' . $rootParent->name . '</a><br>';
                    array_push($productIds, $rootParent->id);
                }
            } else {
                if (!in_array($product->id, $productIds)) {
                    $message .= '<a href="' . action('ProductController@show',
                            $product->id) . '">' . $product->name . '</a><br>';
                    array_push($productIds, $product->id);
                }
            }
        }
        return $message;
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

            return response($file)
                ->header('Content-Type', $type)
                ->header('Content-Length',
                    $size)
                ->setMaxAge(3600)
                ->setPublic()
                ->setEtag($etag)
                ->setLastModified(Carbon::createFromTimestamp($lastModified));
        }

        return redirect(action("Web\ErrorPageController@error404"));
    }

    public function siteMapXML()
    {
        return redirect(action('Web\SitemapController@index'), Response::HTTP_MOVED_PERMANENTLY);
    }

    /**
     * Sends an email to the website's own email
     *
     * @param \app\Http\Requests\ContactUsFormRequest $request
     *
     * @param ErrorPageController                     $errorPageController
     *
     * @return Response
     */
    public function sendMail(ContactUsFormRequest $request, ErrorPageController $errorPageController)
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
        //            return $errorPageController->errorPage($message) ;
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
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: multipart/alternative; boundary="' . $boundary . "\"\r\n";//';charset=UTF-8' .
        $headers .= 'From: ' . strip_tags(config('constants.MAIL_USERNAME')) . "\r\n" . 'Reply-To: ' . strip_tags($email) . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        $orginaltext = $request->get('message');

        $orginaltext = str_replace('\"', '"', $orginaltext);
        $orginaltext = str_replace('\\\\', '\\', $orginaltext);

        $sender = '<p dir="rtl"> نام فرستنده: ' . $name . '</p>';
        if (strlen($email) > 0) {
            $sender .= '<p dir="rtl"> ایمیل فرستنده: ' . $email . '</p>';
        }
        if (strlen($phone) > 0) {
            $sender .= '<p dir="rtl">  شماره تماس فرستنده: ' . $phone . '</p>';
        }

        //plainText version
        $text = "\r\n\r\n--" . $boundary . "\r\n"; //header
        $text .= "Content-type: text/plain; charset=utf-8 \r\n\r\n"; //header

        $text .= strip_tags($orginaltext) . "\r\n" . strip_tags($sender);

        //htmlText version

        $text .= "\r\n\r\n--" . $boundary . "\r\n"; //header
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

        $text .= "\r\n\r\n--" . $boundary . '--';

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

            return $errorPageController->errorPage($message);
        }
    }

    /**
     * Send a custom SMS to the user
     *
     * @param Request $request
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
            return response()->json([], Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
        }

        if (!isset($from) || strlen($from) == 0) {
            $from = $smsNumber;
        }

        $mobiles = [];
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

            return response()->json($smsCredit);
        } else {
            return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function uploadCenter(Request $request)
    {
        $user = $request->user();

        $employees = User::whereHas('roles', function ($q) {
            $q->where('name', config('constants.ROLE_UPLOAD_CENTER'));
        })->pluck('lastName', 'id')->toArray();

        $canSendSMS = ($user->can(config('constants.SEND_SMS_TO_USER_ACCESS'))) ? true : false;

        $files           = null;
        $canSeeFileTable = false;
        if ($user->can(config('constants.LIST_UPLOAD_CENTER_FILES'))) {
            $canSeeFileTable = true;
            $uploaderId      = $request->get('uploader_id');
            $files           = UploadCenter::orderByDesc('created_at');
            if (isset($uploaderId)) {
                $files->where('user_id', $uploaderId);
            }
            $files = $files->paginate(10, ['*'], 'page');
        }

        $linkParameters = request()->except('page');

        return view('admin.uploadCenter', compact('employees', 'files', 'canSendSMS', 'canSeeFileTable', 'linkParameters'));
    }

    public function bigUpload(Request $request)
    {
        $user = $request->user();

        $filePath         = $request->header('X-File-Name');
        $originalFileName = $request->header('X-Dataname');
        $filePrefix       = '';
        $link             = null;

        try {
            $ext = pathinfo($originalFileName, PATHINFO_EXTENSION);

            if (!in_array($ext, ['jpg', 'jpeg', 'JPG', 'png', 'pdf', 'rar', 'zip', 'psd', 'doc'])) {
                File::delete($filePath);
                return response()->json([
                    'error' => [
                        'message' => 'File format is not permitted',
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $fileName = str_random(4) . '.' . $ext;

            $newFileNameDir = '/alaa_media/cdn/upload/u/' . $fileName;

            if (File::exists($newFileNameDir)) {
                File::delete($newFileNameDir);
            }
            File::move($filePath, $newFileNameDir);

            $userId = null;
            if (isset($user)) {
                $userId = $user->id;
            }
            $relativePath = 'upload/u/' . $fileName;
            $link         =
                config('constants.DOWNLOAD_SERVER_PROTOCOL') . config('constants.CDN_SERVER_NAME') . '/' . $relativePath;

            UploadCenter::create([
                'user_id' => $userId,
                'link'    => $relativePath,
            ]);


            return response()->json([
                'fileName' => $fileName,
                'link'     => $link,
                'prefix'   => $filePrefix,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'unexpected error',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function smsLink(Request $request)
    {
        $user = User::Find($request->get('employee_id'));
        if (is_null($user)) {
            return response()->json([
                'error' => [
                    'message' => 'کاربر مورد نظر یافت نشد',
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $link = $request->get('link');
        if (is_null($link)) {
            return response()->json([
                'error' => [
                    'message' => 'ارسال لینک الزامی است',
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->notify(new sendLink($link));

        return response()->json([
            'message' => 'پیامک با موفقیت ارسال شد',
        ]);
    }
}
