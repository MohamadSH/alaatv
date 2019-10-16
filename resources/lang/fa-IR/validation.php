<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => ':attribute فقط می تواند شامل عدد باشد.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute و تکرار آن یکسان نیستند',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => ':attribute باید :digits رقم باشد.',
    'digits_between'       => ':attribute می تواند بین :min تا :max رقم باشد.',
    'email'                => ':attribute باید معتبر باشد.',
    'exists'               => 'مقدار انتخاب شده برای  :attribute معتبر نمی باشد.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'لطفا یک :attribute انتخاب کنید.',
    'in'                   => 'The selected :attribute is fnvalid.',
    'integer'              => ':attribute باید یک عدد باشد',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'فایل :attribute می تواند حداکثر :max کیلوبایت باشد.',
        'string'  => ':attribute نمی تواند بیشتر از :max کاراکتر باشد.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'فرمت های مجاز :attribute : :values',
    'min'                  => [
        'numeric' => ':attribute باید حداقل :min باشد',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => ':attribute باید حداقل :min کاراکتر باشد.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => ':attribute باید رشته ی عددی باشد.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'وارد کردن :attribute الزامیست.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => ':attribute باید وارد شود زیرا هیچکدام از  :values وارد نشده اند',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute قبلا ثبت شده است',
    'uploaded'             => 'آپلود :attribute نا موفق بود.',
    'url'                  => 'معتبر نمی باشد :attribute فرمت',
    'validate'             => 'مقدار :attribute معتبر نمی باشد.',
    'array2d'              => 'مقدار :attribute باید آرایه دو بعدی باشد.',
    "recaptcha"            => 'مقدار :attribute معتبر نمی باشد.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name'        => [
            'rule-name' => 'custom-message',
        ],
        'assignmentstatus_id'   => [
            'min' => 'وضعیت تمرین باید مشخص شود',
        ],
        'consultationstatus_id' => [
            'min' => 'وضعیت مشاوره باید مشخص شود',
        ],
        'major_id'              => [
            'min'    => 'رشته باید مشخص شود',
            'exists' => 'رشته باید مشخص شود',
        ],
        'grade_id'              => [
            'exists' => 'مقطع باید مشخص شود',
        ],
        'userstatus_id'         => [
            'min' => 'وضعیت کاربر باید مشخص شود',
        ],
        'nationalCode'          => [
            'validate' => 'کد ملی معتبر نمی باشد',
        ],
        'orderstatus_id'        => [
            'exists' => 'وضعیت انتخاب شده معتبر نمی باشد',
        ],
        'transactionID'         => [
            'max'         => 'این تراکنش شماره ندارد.',
            'required_if' => 'وارد کردن شماره تراکنش الزامی است.',
        ],
        'usageLimit'            => [
            'required_if' => 'در حالت محدود ، تعیین تعداد مجاز برای استفاده از کپن الزامیست.',
        ],
        'amount'                => [
            'required_if' => 'در حالت محدود ، تعیین تعداد موجود برای کالا الزامیست.',
        ],
        'cost'                  => [
            'required_if' => 'وارد کردن مبلغ الزامیست.',
        ],
        'products'              => [
            'required_if' => 'انتخاب محصول در حالت جزئی الزامیست.',
        ],
        'phoneNumber.*'         => [
            'numeric'  => 'شماره تلفن باید رشته عددی باشد.',
            'required' => 'وارد کردن شماره تلفن الزامیست.',
        ],
        'priority.*'            => [
            'numeric' => 'الویت باید رشته عددی باشد.',
        ],
        'phonetype_id.*'        => [
            'exists' => 'نوع وارد شده معتبر نیست.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'password'                 => 'رمز عبور',
        'oldPassword'              => 'رمز عبور قدیم',
        'email'                    => 'ایمیل',
        'firstName'                => 'نام',
        'lastName'                 => 'نام خانوادگی',
        'fullName'                 => 'نام',
        'mobile'                   => 'شماره موبایل',
        'phone'                    => 'تلفن',
        'nationalCode'             => 'کد ملی',
        'photo'                    => 'عکس',
        'questionFile'             => 'فایل سؤال',
        'solutionFile'             => 'فایل پاسخ',
        'major_id'                 => 'رشته',
        'majors'                   => 'رشته',
        'assignmentstatus_id'      => 'وضعیت تمرین',
        'consultationstatus_id'    => 'وضعیت مشاوره',
        'numberOfQuestions'        => 'تعداد سؤالات',
        'userstatus_id'            => 'وضعیت کاربر',
        'postalCode'               => 'کد پستی',
        'g-recaptcha-response'     => 'عبارت امنیتی',
        'cost'                     => 'مبلغ',
        'transactionID'            => 'شماره تراکنش',
        'transactionstatus_id'     => 'وضعیت تراکنش',
        'name'                     => 'نام',
        'code'                     => 'کد',
        'discount'                 => 'تخفیف',
        'usageNumber'              => 'تعداد استفاده',
        'amount'                   => 'تعداد',
        'basePrice'                => 'قیمت پایه',
        'image'                    => 'عکس',
        'attributeset_id'          => 'دسته صفت',
        'title'                    => 'عنوان',
        'message'                  => 'پیام',
        'mobileNumber'             => 'شماره موبایل',
        'displayName'              => 'نام قابل نمایش',
        'display_name'             => 'نام قابل نمایش',
        'attributecontrol_id'      => 'نوع کنترل صفت',
        'totalNumber'              => 'تعداد بن',
        'gender_id'                => 'جنسیت',
        'genders'                  => 'جنسیت',
        'bonPlus'                  => 'تعداد بن',
        'bonDiscount'              => 'تخفیف بن',
        'paymentmethod_id'         => 'روش پرداخت',
        'referenceNumber'          => 'شماره مرجع',
        'traceNumber'              => 'شماره پیگیری',
        'paycheckNumber'           => 'شماره چک',
        'consultingAudioQuestions' => 'فایل صوتی سوال مشاوره ای',
        'contacttype_id'           => 'نوع مخاطب',
        'relative_id'              => 'نسبت مخاطب',
        'order'                    => 'ترتیب',
        'brief'                    => 'خلاصه',
        'keyword'                  => 'کلمات کلیدی',
        'complimentaryproducts'    => 'اشانتیون',
        'producttype_id'           => 'نوع محصول',
        'file'                     => 'فایل',
        'files'                    => 'فایل',
        'rank'                     => 'رتبه',
        'participationCode'        => 'کد داوطلبی',
        'reportFile'               => 'فایل کارنامه',
        'phoneNumber'              => 'شماره تلفن',
        'grades'                   => 'مقطع',
        'grade_id'                 => 'مقطع',
        'contenttypes'             => 'نوع محتوا',
        'user_id'                  => 'کاربر',
        'date'                     => 'تاریخ',
        'score'                    => 'نمره',
        'province'                 => 'استان',
        'city'                     => 'شهر',
        'school'                   => 'مدرسه',
        'introducedBy'             => 'معرف',
        'address'                  => 'آدرس',
        'credit'                  => 'اعتبار',
        'context'                 => 'متن',
    ],

    "FileArray" => [
        'name should be set'                                 => 'برای هر آیتم، name باید مقدار دهی شده باشد. ',
        'each field should be string'                        => 'مقادیر هر آیتم باید string باشد.',
        'each item in array should be instance of std class' => 'هر آیتم باید از نوع stdclass باشد.',
        'should be An array'                                 => ':attribute باید آرایه باشد.',
    ],

    'phone' => 'شماره :attribute به درستی وارد نشده است.',
];
