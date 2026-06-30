<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OperatorPanel extends Component
{
    public $activeOrder = null;
    public $checklist = []; // To store the checked items state locally

    public function mount()
    {
        $this->loadActiveOrder();
    }

    public function loadActiveOrder()
    {
        $this->activeOrder = Order::with('client')
            ->where('operator_id', Auth::id() ?? 1) // Fallback to 1 for testing if not auth
            ->whereIn('status', ['assigned', 'picked_up'])
            ->first();
            
        if ($this->activeOrder && empty($this->checklist)) {
            // Simple parse: split by comma or newline to create a checklist
            $items = preg_split('/[\n,]+/', $this->activeOrder->petition);
            foreach($items as $index => $item) {
                if (trim($item)) {
                    $this->checklist[$index] = [
                        'text' => trim($item),
                        'found' => false
                    ];
                }
            }
        }
    }

    public function toggleItem($index)
    {
        if (isset($this->checklist[$index])) {
            $this->checklist[$index]['found'] = !$this->checklist[$index]['found'];
        }
    }

    public function updateStatus($newStatus)
    {
        if ($this->activeOrder) {
            $this->activeOrder->update(['status' => $newStatus]);
            if ($newStatus === 'delivered') {
                $this->activeOrder = null;
                $this->checklist = [];
            }
            $this->loadActiveOrder();
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
        return view('livewire.operator-panel');
    }
}
