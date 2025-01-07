<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Posts extends Component
{
    use WithFileUploads;
    public $title;
    public $body;
    public $image;
    public $postId = null;
    public $newImage;
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
    $this->reset();
    // Récupérer les données du post à éditer et les afficher dans le formulaire
    $this->showModalForm = true;
    $this->postId = $id;
    $this->loadEditForm();
}

public function loadEditForm()
{
    // Chargez les données du post à éditer dans les propriétés du composant
    $post = Post::findOrFail($this->postId);
    $this->title = $post->title;
    $this->body = $post->body;
    $this->newImage = $post->image;
}

public function updatePost()
{
    $this->validate([
        'title' => 'required',
        'body' => 'required',
        'image' => 'image|max:1024|nullable',
    ]);
    // Trouver le post à mettre à jour
    if($this->image) {
        Storage::delete('photos', $this->newImage, 'public');
        $this->newImage = $this->image->getClientOriginalName();
        $this->image->storeAs('photos', $this->newImage, 'public');
    }

    Post::find($this->postId)->update([
        'title' => $this->title,
        'body' => $this->body,
        'image' => $this->newImage
    ]);
    $this->reset();
}

    public function render()
    {
        return view('livewire.posts', [
            'posts' => Post::all()
        ]);
    }
}
