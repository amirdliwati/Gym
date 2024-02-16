<?php

namespace App\Http\Controllers\training;

use Controller, Auth;
use Illuminate\Http\Request;
use App\Models\{Offer,Offer_detail,Offer_trainee,Currencie};

class OffersController extends Controller
{
	public function Offers(Request $Request)
    {
        if ($this->CheckPermission('OfferManage') == true)
        {
            if ($Request->isMethod('post'))
            {
                $newOffer = new Offer();
                $newOffer -> title = $Request->input('title');
                $newOffer -> start_date = $Request->input('start_date');
                $newOffer -> count_trainee = $Request->input('count_trainee');
                $newOffer -> expire_date = $Request->input('expire_date');
                $newOffer -> amount = $Request->input('amount');
                $newOffer -> currency_id = $Request->input('currency');
                $newOffer -> save();

                $newOfferDetail = new Offer_detail();
                $newOfferDetail -> description = $Request->input('details');
                $newOfferDetail -> offer_id = $newOffer->id;
                $newOfferDetail -> save();

                $this->AddToLog('Added Offer',$newOffer->title , $newOffer->id);
                $Request->session()->put('msgSuccess', 'Offer has been added successfully');
            }
            else
            {
                $Offers = Offer::all();
                $Currencies = Currencie::where('status',1)->get();
                $arr = array('Offers' => $Offers, 'Currencies' => $Currencies);
                return view('training/Offers/OffersManage',$arr);
            }
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }

    public function EditOffer(Request $Request)
    {
        if ($this->CheckPermission('OfferModify') == true)
        {
            if ($Request->isMethod('post'))
            {
                $editOffer = Offer::find($Request->input('OfferID'));
                $editOffer -> title = $Request->input('title');
                $editOffer -> start_date = $Request->input('start_date');
                $editOffer -> count_trainee = $Request->input('count_trainee');
                $editOffer -> expire_date = $Request->input('expire_date');
                $editOffer -> amount = $Request->input('amount');
                $editOffer -> currency_id = $Request->input('currency');
                $editOffer -> save();

                $editOfferDetail = Offer_detail::where('offer_id',$editOffer->id)->first();
                $editOfferDetail -> description = $Request->input('details');
                $editOfferDetail -> save();

                $this->AddToLog('Edited Offer',$editOffer->title , $editOffer->id);
                $Request->session()->put('msgWarning', 'Offer has been edited successfully');
            }
            else
            {
                $Offer = Offer::find($Request->OfferID);
                $Currencies = Currencie::where('status',1)->get();
                $arr = array('Offer' => $Offer, 'Currencies' => $Currencies);
                return view('training/Offers/EditOffer',$arr);
            }
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }

    public function GetOfferDetails(Request $Request)
    {
        if ($this->CheckPermission('OfferManage') == true)
        {
            $Offer = Offer::find($Request->OfferID);
            return response()->json($Offer->offer_detail->description);
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }

    public function DeleteOffer(Request $Request)
    {
        if ($this->CheckPermission('OfferModify') == true)
        {
            $Offer = Offer::find($Request->OfferID);
            $Offer -> delete();
            return response()->json('ok');
        }
        else
        {
            return response()->json('Access Denied');
        }
    }
}
