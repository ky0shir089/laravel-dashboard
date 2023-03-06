<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $status = "error";
        $message = "";
        $data = [];
        $code = 400;

        $sort_by = $request->sort_by;
        $search = $request->search;

        try {
            $user = User::where("uid", $request->uid)->first();
            $qwe = User::where("id", $user->id)
                ->with("employment:employees.id,employee_nik,employee_name,job_id,job_name,position_id,position_name,department_id,department_name,employees.outlet_id,outlet_name")
                ->with("accessOutlet:id,outlet_id,outlet_name,branch_id")
                ->first();

            $status = 'success';
            $message = 'ok';
            $data = $qwe;
            $code = 200;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|string|min:4|unique:users,uid',
            'name' => 'required|string',
        ]);

        $message = "";
        $data = [];
        $code = 400;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {
            try {
                $sql = new User;
                $sql->uid = $request->uid;
                $sql->name = $request->name;
                $sql->password = Hash::make(12345678);
                $sql->fonnte_token = $request->fonnte_token;
                $sql->created_by = auth()->id();
                $sql->updated_at = null;
                $sql->save();

                $message = 'Register sukses';
                $data = $sql->toArray();
                $code = 200;
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function verify(Request $request)
    {
        $response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => env('RECAPTCHAV3_SECRET'),
            'response' => $request->token,
            'remoteip' => $request->ip()
        ]);

        return $response;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|string|min:4',
            'password' => ['required', 'string', Password::min(8)],
        ]);

        $message = "";
        $data = [];
        $access_token = "";
        $code = 400;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {
            try {
                $user = User::where("uid", $request->uid)->first();

                if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        if ($user->status == "ACTIVE") {
                            $user->ipaddress = $request->ip();
                            $user->useragent = $request->userAgent();
                            $user->save();

                            Auth::login($user);
                            $access_token = $user->createToken('auth-token', ['*'], now()->addDay(1))->plainTextToken;

                            $message = 'Login sukses';
                            $data = $user;
                            $access_token = $access_token;
                            $code = 200;
                        } else {
                            $message = "Akun anda sudah disable, silahkan hubungi administrator";
                        }
                    } else {
                        $message = "Login gagal, id atau password salah";
                    }
                } else {
                    $message = "Login gagal, id atau password salah";
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        return response()->json([
            'message' => $message,
            'data' => $data,
            'access_token' => $access_token,
        ], $code);
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'old_password' => ['required', 'string', Password::min(8)],
            'new_password' => ['required', 'string', Password::min(8)->letters()->numbers()],
        ]);

        $message = "";
        $data = [];
        $code = 400;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {

            try {
                $sql = User::findorfail($request->id);

                if (Hash::check($request->old_password, $sql->password)) {
                    $sql->password = Hash::make($request->new_password);
                    $sql->chpass = "NO";
                    $sql->save();

                    $message = 'Data Updated';
                    $data = $sql->toArray();
                    $code = 200;
                } else {
                    $message = "password salah";
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'chpass' => 'required|string',
            'status' => 'required|string',
        ]);

        $message = "";
        $data = [];
        $code = 400;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {
            try {
                $sql = User::findOrFail($request->id);
                if ($request->chpass == "YES") {
                    $sql->password = Hash::make(12345678);
                }
                $sql->chpass = $request->chpass;
                $sql->status = $request->status;
                $sql->updated_by = auth()->id();
                $sql->save();

                $message = 'Update sukses';
                $data = $sql->toArray();
                $code = 200;
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
