<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermCondition;
use App\Models\PrivacyPolicy;

class TermConditionController extends Controller
{
    public function TermCondition()
    {
        $terms = TermCondition::first();
        return view('admin.component.term_condition', compact('terms'));
    }


    public function storeTermCondition(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $TermCondition = TermCondition::first();

        if ($TermCondition) {
            $TermCondition->update([
                'title' => $request->title,
                'content' => $request->content,

            ]);
        } else {
            TermCondition::create([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        return redirect()->back()->with('success', 'Terms & Condition updated successfully!');
    }

    public function privacypolicy()
    {
        $privacypolicy = PrivacyPolicy::first();
        return view('admin.component.privacy_policy', compact('privacypolicy'));
    }


    public function storeprivacypolicy(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $PrivacyPolicy = PrivacyPolicy::first();

        if ($PrivacyPolicy) {
            $PrivacyPolicy->update([
                'title' => $request->title,
                'content' => $request->content,

            ]);
        } else {
            PrivacyPolicy::create([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        return redirect()->route('privacypolicy')->with('success', 'privacy policy updated successfully!');
    }
    public function shippingpolicy()
    {

        $shippingpolicy = PrivacyPolicy::find(2);
        return view('admin.component.shipping_policy', compact('shippingpolicy'));
    }

    public function shippingpolicystore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $shippingPolicy = PrivacyPolicy::find(2);

        if ($shippingPolicy) {

            $shippingPolicy->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {

            PrivacyPolicy::create([
                'id' => 2,
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        return redirect()->route('shippingpolicy')->with('success', 'Privacy policy updated successfully!');
    }
    public function refundpolicy()
    {

        $refundPolicy = PrivacyPolicy::find(3);
        return view('admin.component.refund_policy', compact('refundPolicy'));
    }

    public function refundpolicystore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $refundPolicy = PrivacyPolicy::find(3);

        if ($refundPolicy) {

            $refundPolicy->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {

            PrivacyPolicy::create([
                'id' => 3,
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        return redirect()->route('refundpolicy')->with('success', 'Privacy policy updated successfully!');
    }
}
