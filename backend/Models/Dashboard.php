<?php

namespace App\Models;

use App\DB\RepositoryModel;
use App\Exceptions\TooFewArgumentsSupplied;
use App\Exceptions\TooManyArgsException;

class Dashboard extends RepositoryModel
{


    public function getTotalOrders(): bool|string|int
    {
        return $this->table('orders')->count('total_orders')[0]['total_orders'];
    }

    /**
     * @throws TooManyArgsException|TooFewArgumentsSupplied
     */
    public function getTotalCompletedOrders(): bool|string|int
    {
        return $this->table('orders')->where('completed', '1')->count('total_completed')[0]['total_completed'];
    }

    /**
     * @throws TooManyArgsException
     * @throws TooFewArgumentsSupplied
     */
    public function getTotalPending()
    {
        return $this->table('orders')->where('completed', '0')->count('total_pending')[0]['total_pending'];
    }


    /**

     * total orders (completed and not)
     * total completed orders
     * total pending orders
     * total registered users
     * total guest visits
     */

}