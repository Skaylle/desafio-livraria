<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assunto extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string $table
     */
    protected $table = 'assuntos';

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = 'cod_assunto';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'descricao',
        'deleted_at',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    public static function getDefaultOrderBy()
    {
        return 'cod_assunto';
    }

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_assunto', 'cod_assunto', 'cod_livro')
                    ->withPivot('deleted_at')
                    ->withTimestamps();
    }
}
