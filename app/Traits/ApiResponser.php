<?php
 namespace App\Traits;
 use Illuminate\Support\Collection;
 use Illuminate\Database\Eloquent\Model;
 trait ApiResponser
 {
   private function succesResponse($data,$code)
   {
     return response()->json($data,$code);
   }
   protected function succesEcho($data,$code=200)
   {
     return response()->json($data,$code);
   }
   protected function success($data,$code=200)
   {
     return response()->json($data,$code);
   }
   protected function errorResponse($menssage,$code)
   {
     return response()->json(['error'=>$menssage,'code'=>$code],$code);
   }

   protected function showAll(Collection $collection,$code=200)
   {
     return $this->succesResponse(['data'=>$collection],$code);
   }

   protected function showOne(Model $instance,$code=200)
   {
     return $this->succesResponse(['data'=>$instance],$code);
   }

 }
