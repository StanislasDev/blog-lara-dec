<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Posts extends Component
{
    use WithFileUploads;
    public $title;
    public $body;
    public $image;
    public $postId = null;
    public $showModalForm = false;

    public function showCreatePostModal()
    {
        $this->showModalForm = true;
    }

    public function storePost()
{
    $this->validate([
        'title' => 'required',
        'body' => 'required',
        'image' => 'required|image|max:1024', // Augmentez la limite à 1024 pour autoriser 1 Mo
    ]);

    // Enregistrer l'image
    $image_name = $this->image->getClientOriginalName();
    $this->image->storeAs('photos', $image_name, 'public');

    // Créer le post
    $post = new Post();
    $post->user_id = auth()->user()->id;
    $post->title = $this->title;
    $post->slug = Str::slug($this->title);
    $post->body = $this->body;
    $post->image = $image_name; // Utilisez $image_name ici
    $post->save();

    // Réinitialiser les champs du formulaire
    $this->reset();

    // Optionnel : fermez le modal
    // $this->showModalForm = false;

    // Ajouter un message de succès
    // session()->flash('message', 'Post créé avec succès !');
}
public function showEditPostModal($id)
{
    $this->showModalForm = true;
    $this->postId = $id;
}

    public function render()
    {
        return view('livewire.posts', [
            'posts' => Post::all()
        ]);
    }
}
