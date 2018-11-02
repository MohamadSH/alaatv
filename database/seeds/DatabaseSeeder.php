<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(BlocksTableSeeder::class);



/*        $this->call(AssignmentStatusSeeder::class);
        $this->call(ConsultationStatusSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(PaymentStatusSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserStatusSeeder::class);
        $this->call(TransactionStatusSeeder::class);
        $this->call(AttributeTypeSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(TransactionGatewaysSeeder::class);
        $this->call(BonSeeder::class);
        $this->call(UserBonStatusSeeder::class);
        $this->call(AttributeControlSeeder::class);
        $this->call(UserUploadStatusSeeder::class);
        $this->call(ContacttypeSeeder::class);
        $this->call(PhonetypeSeeder::class);
        $this->call(RelativeSeeder::class);
        $this->call(CouponTypeSeeder::class);
        $this->call(OnlineTransactionGatewaysSeeder::class);
        $this->call(ProductFileTypeSeeder::class);
        $this->call(VerificationMessageStatusSeeder::class);
        $this->call(WebsitePageSeeder::class);
        $this->call(MajorInterrelationTypeSeeder::class);
        $this->call(MajorTypeSeeder::class);
        $this->call(ContentTypeInterrelationSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(CheckoutStatusSeeder::class);
        $this->call(OrderproductTypeSeeder::class);
        $this->call(OrderproductInterrelationSeeder::class);
        $this->call(TransactionInterrelationSeeder::class);
        $this->call(ProductInterrelationSeeder::class);
        $this->call(BloodTypeSeeder::class);
        $this->call(DiscountTypeSeeder::class);
        $this->call(WallettypeSeeder::class);*/
    }
}
