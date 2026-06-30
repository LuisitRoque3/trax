<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TrafficControlPanel extends Component
{
    // Form fields
    public $client_name = '';
    public $client_phone = '';
    public $petition = '';
    public $destination = '';
    
    // Search properties
    public $client_search = '';
    public $selected_client_id = null;

    public function selectClient($clientId)
    {
        $client = Client::find($clientId);
        if ($client) {
            $this->selected_client_id = $client->id;
            $this->client_name = $client->name;
            $this->client_phone = $client->phone;
            $this->destination = $client->default_destination;
            $this->client_search = '';
        }
    }

    public function resetClient()
    {
        $this->selected_client_id = null;
        $this->client_name = '';
        $this->client_phone = '';
        $this->destination = '';
    }

    public function createOrder()
    {
        $this->validate([
            'client_name' => 'required|string',
            'petition' => 'required|string',
            'destination' => 'required|string',
        ]);

        // Find or create client
        if (!$this->selected_client_id) {
            $client = Client::firstOrCreate(
                ['phone' => $this->client_phone ?: null],
                [
                    'name' => $this->client_name,
                    'default_destination' => $this->destination
                ]
            );
            $this->selected_client_id = $client->id;
        }

        Order::create([
            'client_id' => $this->selected_client_id,
            'petition' => $this->petition,
            'destination' => $this->destination,
            'status' => 'pending'
        ]);

        $this->reset(['client_name', 'client_phone', 'petition', 'destination', 'selected_client_id', 'client_search']);
    }

    public function assignOperator($orderId, $operatorId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update([
                'operator_id' => $operatorId,
                'status' => 'assigned'
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        $clients = [];
        if (strlen($this->client_search) >= 2) {
            $clients = Client::where('name', 'like', '%' . $this->client_search . '%')
                ->orWhere('phone', 'like', '%' . $this->client_search . '%')
                ->take(5)
                ->get();
        }

        $pendingOrders = Order::with(['client', 'operator'])
            ->whereIn('status', ['pending', 'assigned', 'picked_up'])
            ->latest()
            ->get();
            
        $operators = User::where('role', 'operator')->get();

        return view('livewire.traffic-control-panel', [
            'suggestedClients' => $clients,
            'pendingOrders' => $pendingOrders,
            'operators' => $operators,
        ]);
    }
}
