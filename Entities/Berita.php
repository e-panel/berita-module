<?php

namespace Modules\Berita\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Berita extends Model 
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'berita';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'foto', 
        'sumber_foto', 
        'judul', 
        'slug', 
        'preview', 
        'isi', 
        'sumber', 
        'komentar', 
        'headline', 
        'view', 
        'status', 
        'id_operator', 
        'id_kategori', 
        'created_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public $appends = [
        'url', 
        'uploaded_time'
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = uuid();
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }

    /**
     * Scope a query for UUID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query, $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUuid($query, $uuid) 
    {
        return $query->whereUuid($uuid);
    }

    /**
     * Get photo's url
     *
     * @return string
     */
    public function getUrlAttribute() 
    {
        return \Storage::disk()->url($this->foto);
    }
    
    /**
     * Get uploaded time
     *
     * @return string
     */
    public function getUploadedTimeAttribute() 
    {
        return $this->created_at->diffForHumans();
    }
    
    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori() 
    {
        return $this->belongsTo('Modules\Berita\Entities\Kategori', 'id_kategori');
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator() 
    {
        return $this->belongsTo('Modules\Pengguna\Entities\Operator', 'id_operator');
    }
}