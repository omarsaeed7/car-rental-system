<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Car;
use App\Models\Order;
use App\enums\PaymentMethod;
use App\enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'car_id' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);
            $start_date = Carbon::parse($request->start_date);
            $current_date = Carbon::now()->format('Y-m-d');
            $start_date_only = $start_date->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date);

            if ($start_date_only < $current_date) {
                return response()->json(['error' => 'Start date must be in future.'], 400);
            }
            if ($start_date->greaterThan($end_date)) {
                return response()->json(['error' => 'Start date cannot be later than end date.'], 400);
            }

            $days = $start_date->diffInDays($end_date);
            $car = Car::findOrFail($request->car_id);
            if (!$car->availability_status) {
                return response()->json(['error' => 'Car not Available'], 400);
            }
            $price = $car->price_per_day;
            // ==============
            if ($days > 7) {
                $total_price = $price * ($days + 1) * (1 - 0.10);
            } else {
                $total_price = $price * ($days + 1);
            }
            $total_price = round($total_price, 2);
            //===========

            // Format the dates to store in the database
            $start_date = $start_date->format('Y-m-d');
            $end_date = $end_date->format('Y-m-d');

            // Create the order and save to the database
            $order = Order::create([
                'user_id' => $request->user_id,
                'car_id' => $request->car_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_price' => $total_price,
            ]);
            Car::where('id', $request->car_id)->update([
                'availability_status' => 0,
            ]);
            return response()->json($order, 201);
        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage()); // For Query Exception
            return response()->json(['error' => 'Something went wrong.', 'message' => $e->getMessage()], 500);
        }
    }

    public function updatePayment(Request $request)
    {
        $orderId = (int) $request->orderId;
        try {
            $order = Order::findOrFail($orderId);
            $order->update([
                'payment_status' => PaymentStatus::PAID,
                'payment_method' => PaymentMethod::CASH,
            ]);
            return response()->json(['message' => 'Payment updated successfully'], 200);
        } catch (Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update payment, Order Not Found'], 500);
        }
    }
    public function getUserOrders($id)
    {
        try {
            if (!$id) {
                return response()->json(['error' => 'No Orders For This User']);
            }
            $userId = (int) $id;
            $userOrders = Order::where('user_id', $userId)->get();
            return response()->json($userOrders, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.', 'message' => $e->getMessage()], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            return response()->json($order, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order Not Found'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $request->validate([
                'car_id' => 'integer',
                'start_date' => 'date',
                'end_date' => 'date',
            ]);
            $start_date = Carbon::parse($request->start_date);
            $current_date = Carbon::now()->format('Y-m-d');
            $start_date_only = $start_date->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date);

            if ($start_date_only < $current_date) {
                return response()->json(['error' => 'Start date must be in future.'], 400);
            }
            if ($start_date->greaterThan($end_date)) {
                return response()->json(['error' => 'Start date cannot be later than end date.'], 400);
            }

            $days = $start_date->diffInDays($end_date);
            if ($request->car_id) {
                $car = Car::findOrFail($request->car_id);
                if (!$car->availability_status) {
                    return response()->json(['error' => 'Car not Available'], 400);
                }
            }
            $price = Car::find($order->car_id)->price_per_day;
            // ==============
            if ($days > 7) {
                $total_price = $price * ($days + 1) * (1 - 0.10);
            } else {
                $total_price = $price * ($days + 1);
            }
            $total_price = (int) round($total_price, 2);
            //===========

            $start_date = $start_date->format('Y-m-d');
            $end_date = $end_date->format('Y-m-d');
            
            // dd($request->all());
            $updateData = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_price' => $total_price,
            ];
            $order->update($updateData);       
            
            Car::where('id', $request->car_id)->update([
                'availability_status' => 0,
            ]);
            
            return response()->json(['message' => 'Order updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $carId = $order->car_id;
            $order->delete();
            Car::where('id', $carId)->update([
                'availability_status' =>  '1'
            ]);
            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order Not Found'], 404);
        }
    }
}
