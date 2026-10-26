<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenteVirtualEmail extends Model
{
    protected $table = 'asistente_virtual_email_sends';

    protected $fillable = ['email'];
}
