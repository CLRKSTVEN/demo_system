<?php
// application/models/POSModel.php
class POSModel extends CI_Model
{
    public function get_inventory()
    {
        return $this->db->get('canteen_inventory')->result();
    }

    public function get_card_balance($student_number)
    {
        $row = $this->db->get_where('student_cards', ['StudentNumber' => $student_number])->row();
        return $row ? $row->card_balance : 0;
    }

    public function reload_card($student_number, $amount)
    {
        $exists = $this->db->get_where('student_cards', ['StudentNumber' => $student_number])->row();
        if ($exists) {
            $this->db->set('card_balance', 'card_balance + ' . (float)$amount, FALSE)
                ->where('StudentNumber', $student_number)
                ->update('student_cards');
        } else {
            $this->db->insert('student_cards', [
                'StudentNumber' => $student_number,
                'card_balance' => $amount,
                'last_reloaded_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->db->insert('card_transactions', [
            'StudentNumber' => $student_number,
            'amount' => $amount,
            'type' => 'reload',
            'payment_method' => 'cash',
            'transaction_date' => date('Y-m-d H:i:s')
        ]);
    }

    public function process_purchase($student_number, $item_id, $quantity)
    {
        $item = $this->db->get_where('canteen_inventory', ['id' => $item_id])->row();
        if (!$item || $item->quantity < $quantity) return false;

        $total = $item->price * $quantity;
        $balance = $this->get_card_balance($student_number);

        if ($balance >= $total) {
            $this->db->set('card_balance', 'card_balance - ' . $total, FALSE)
                ->where('StudentNumber', $student_number)
                ->update('student_cards');
            $payment_method = 'card';
        } else {
            $payment_method = 'cash';
        }

        $this->db->insert('pos_sales', [
            'StudentNumber' => $student_number,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'total_price' => $total,
            'payment_method' => $payment_method,
            'transaction_date' => date('Y-m-d H:i:s')
        ]);

        $this->db->set('quantity', 'quantity - ' . $quantity, FALSE)
            ->where('id', $item_id)
            ->update('canteen_inventory');

        $this->db->insert('card_transactions', [
            'StudentNumber' => $student_number,
            'amount' => -$total,
            'type' => 'purchase',
            'payment_method' => $payment_method,
            'transaction_date' => date('Y-m-d H:i:s')
        ]);
    }
}
