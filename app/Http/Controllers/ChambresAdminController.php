<?php

namespace App\Http\Controllers;

use App\Chambres;
use App\Chambres_Commodites;
use App\Commodites;

use Illuminate\Http\Request;

class ChambresAdminController extends Controller
{
   
   

 
     /**
     * Create a new controller instance.
     *
     * @return void
     */

   public function __construct()
   {
       $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    
   public function index()
    {
       $chambres_dispo= Chambres::where('status',"disponible")->paginate(5);
       $chambres = Chambres::orderBy('created_at','desc')->paginate(5);
       $commodites = Commodites::paginate(5);
       return view('chambres.index', compact('chambres','commodites','chambres_dispo'))->with('i', (request()->input('page', 1) - 1) * 5);
  
    }



   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chambres.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'nom' => 'required',
            'type' => 'required',
            'description' => 'required',
            'status'=> 'required',
            'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'prix_pax'=>'required'
        ]);

        $image = $request->file('image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);

        //NEW
        $chambre=new Chambres;
        $chambre->type=$request->type;
        $chambre->nom=$request->nom;
        $chambre->description=$request->description;
        $chambre->status=$request->status;
        $chambre->prix_pax=$request->prix_pax;
        $chambre->image=$new_name;
        $chambre->save();
        
        //$chambre->commodites is the name of the function calling function here :
        //@foreach ($chambre->commodites as $one_commodites)
        $chambre->commodites()->sync($request->commodites_icon,false);


        return redirect()->route('chambres.index')
                            ->with('success', 'chambres Created Successfully!');
    }



    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Chambres $chambre)
    {
        return view('chambres.show', compact('chambre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Chambres $chambre)
    {
        $commodites = Commodites::get();
        return view('chambres.edit', compact('chambre','commodites'));
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //THIS FUNCTION BUILD BY HAYTHEM XD :
    public function update_dispo(Request $request,$id)
    {
        
        $id=$request->id;
        //$disp=$request->status;
        //Chambres::find($id)->update(['status' => 'occupe']);

      

        $disp=Chambres::find($id)->status;
           if($disp=='disponible'){
            Chambres::find($id)->update(['status' => 'occupe']);
           }
            else
           {  Chambres::find($id)->update(['status' => 'disponible']);;

           }

           return redirect()->route('chambres.index');

    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chambres $chambre)
    {


        $image_name = $request->hidden_image;
        $image = $request->file('image');




        if($image != '')
        {
        $request->validate([
            'nom' => 'required',
            'type'=>'required',
            'description' => 'required',
            'status' => 'required',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'prix_pax'=>'required',
            'commodites_icon'=>'required'
        ]);
        $image_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $image_name);
        }


        else
        {
            $request->validate([
                'nom' => 'required',
                'type'=>'required',
                'description' => 'required',
                'status' => 'required',
                'prix_pax'=>'required',
                'commodites_icon'=>'required'
            ]);
            $image_name =$chambre->image;
        }

        //UPDATE :
        $chambre->nom=$request->nom;
        $chambre->type=$request->type;
        $chambre->description=$request->description;
        $chambre->status=$request->status;
        $chambre->prix_pax=$request->prix_pax;
        $chambre->image=$image_name;
        $chambre->update();
        $chambre->commodites()->sync($request->commodites_icon,true);
        
        return redirect()->route('chambres.index')
                            ->with('success', 'Commodites Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy( Chambres $chambre)
    {
        //delet from the chambre table 
        $chambre->delete();
        //delete from the chambre_commodites table :
        $chambre->commodites()->detach();
        return redirect()->route('chambres.index')
                            ->with('success', 'Commodites Deleted Successfully!');
    }




    

}
