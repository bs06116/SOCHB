<div>
    <form>
        <div class="text-center rounded-pill mt-4 px-1 py-1">
            <i class="fa fa-search  rounded-pill search" aria-hidden="true"></i>
            <input wire:model.debounce.500ms="search" class="px-4 rounded-pill text-right search-input" type="search">
        </div>
    </form>

    @foreach ($posts as $key => $post)
             @livewire('item', ['post' => $post], key($post->id))
    @endforeach
</div>
