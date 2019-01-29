<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

//class TagginTest extends TestCase
//{
////    protected $bucket ;
////    protected $id;
////    protected $tags ;
////    protected $score ;
////    public function setUp()
////    {
////        $this->bucket = "video";
////        $this->id = 5;
////        $this->tags = ["shamizadeh","mohammad","sohrab"];
////        $this->score = Carbon::now()->micro;
////
////        parent::setUp();
////    }
////    /**
////     * A basic test example.
////     *
////     * @return void
////     */
//
////    public function testAddTagController(){
////
////        $this->assertTrue(true);
//////
//////        $t = json_encode($this->tags);
//////        $response = $this->json('PUT', '/api/v1/rt/id/'.$this->bucket."/".$this->id, [
//////            'score' => $this->score,
//////            'tags' => $t
//////        ]);
//////
//////        $response->assertStatus(200)->assertJson([
//////            'msg' => true
//////        ]);
//////
//////        $this->RemoveTagController();
////    }
//
////    private function RemoveTagController(){
////        $response = $this->json('DELETE', '/api/v1/rt/id/'.$this->bucket."/".$this->id);
////        $response->assertStatus(200)->assertJson([
////            'msg' => true
////        ]);
////    }
//
//
//}
