<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livro extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string $table
     */
    protected $table = 'livros';

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = 'cod_livro';

     public $incrementing = true;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'ano_publicacao',
        'valor',
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
        return 'cod_livro';
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'cod_livro', 'cod_autor')
                    ->withPivot('deleted_at')
                    ->withTimestamps();
    }

    public function assuntos()
    {
        return $this->belongsToMany(Assunto::class, 'livro_assunto', 'cod_livro', 'cod_assunto')
                    ->withPivot('deleted_at')
                    ->withTimestamps();
    }
}
