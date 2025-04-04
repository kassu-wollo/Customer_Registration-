<?php
namespace App\Http\Controllers;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\UserReg;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;
use function Termwind\render;

class CustomerController extends Controller{
public function userShow(){
    return inertia::render('custom');
        }
public function display(){
    return inertia::render('RegisterUser');
    }
    public function custreg(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'bdate' => 'required|date|before:today',
            'email' => 'required|email|unique:userg,email|max:255',
        ]);
        // Create a new user
        UserReg::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'bdate' => $validated['bdate'],
            'email' => $validated['email'],
        ]);
        return inertia::render('View');

/*
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'bdate' => 'required|date|before:today',
            'email' => 'required|email|unique:userg,email|max:255',
        ]);

        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }
       else
        // Create a new user
        UserReg::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'bdate' => $validated['bdate'],
            'email' => $validated['email'],
        ]);
        return inertia::render('View');
        // Redirect or respond with a success message
        /*$validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'bdate' => 'required|date',
            'email' => 'required|email|unique:userg,email|max:255',
        ]);
        $user = UserReg::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'bdate' => $validated['bdate'],
            'email' => $validated['email'],
        ]);
         $user->save();
         return redirect()->route('View')->with('success', 'Registration successful! You can now log in.');
         UserReg::create($request->all());
         return inertia::render('View');*/

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Inertia::render('Auth/Register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Customer::create($request->all());
        // return redirect()->back()->with("success")
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = UserReg::findOrFail($id);
        $item->update($request->all());
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function show()
    {
    $users = UserReg::all(); // Fetch your user data
    return Inertia::render('View', ['posts' => $users]);
    //return inertia('View', ['UserShow' => $users, ]);// Pass it as a prop to the Inertia page

    }
    public function destroy($id)
    {
            $item = UserReg::findOrFail($id);
            $item->delete();
           // return redirect()->route('view')->with('success', 'Item deleted successfully.');

//            return redirect()->route('View')->with('success', 'Item deleted successfully');


    }
    public function export()
    {
        return Excel::download(new ItemsExport, 'user.xlsx');
    }


public function exportPDF()
{
   // return pdf::download(new ItemsExport,'users.pdf');
}

public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));
            return back()->with('success', 'Users imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error importing the file.');
        }
    }
    public function deleteall()
    {
        UserReg::query()->delete();

        return back()->with('success', 'All data has been deleted successfully.');
    }

public function login(){
return Inertia::render('Auth/Login');}
 public function flogin(){
$role=auth::User()->role;
 if($role=="admin"){
 return Inertia::render('Admin/admin');
}
}

public function admin(){
    return Inertia::render('admin.admin');
}
public function bot()
{
$users = Customer::all(); // Fetch your user data
$questions = [
    1 => "1. እራሴን ለማረጋጋት እቸገራለሁ?",
    2 => "2. አፌ ሲደርቅ ይታወቀኛል?",
    3 => "3. ጥሩ ወይም አዎንታዊ ስሜት ፈፅሞ የሚሰማኝ አይመስለኝም?",
    4 => "4. ምንም አካላዊ እንቅስቃሴ ሳላደርግ ለመተንፈስ እቸገራለሁ?",
];
$responses = DB::table('customers')
    ->select('question_number', 'response', DB::raw('COUNT(response) as count'))
    ->groupBy('question_number', 'response')
    ->orderBy('question_number')
    ->get();
    $total = DB::table('customers')->distinct('user_id')->count('user_id');
    $grouped = [];
    foreach ($responses as $row) {
        $grouped[$questions[$row->question_number]][$row->response] = $row->count;
    }
return Inertia::render('bot', [
    'groupedResponses' => $grouped,'total'=>$total,'posts' => $users
]);
//return Inertia::render('bot', ['posts' => $users]);
//return inertia('View', ['UserShow' => $users, ]);// Pass it as a prop to the Inertia page

}

public function vbot()
{
    $questions = [
        1 => "1. እራሴን ለማረጋጋት እቸገራለሁ?",
        2 => "2. አፌ ሲደርቅ ይታወቀኛል?",
        3 => "3. ጥሩ ወይም አዎንታዊ ስሜት ፈፅሞ የሚሰማኝ አይመስለኝም?",
        4 => "4. ምንም አካላዊ እንቅስቃሴ ሳላደርግ ለመተንፈስ እቸገራለሁ?",
    ];
    $responses = DB::table('customers')
        ->select('question_number', 'response', DB::raw('COUNT(response) as count'))
        ->groupBy('question_number', 'response')
        ->orderBy('question_number')
        ->get();
        $total = DB::table('customers')->distinct('user_id')->count('user_id');
        $grouped = [];
        foreach ($responses as $row) {
            $grouped[$questions[$row->question_number]][$row->response] = $row->count;
        }
    return Inertia::render('response', [
        'groupedResponses' => $grouped,'total'=>$total
    ]);
}

}
