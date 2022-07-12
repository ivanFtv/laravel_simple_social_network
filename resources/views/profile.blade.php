
@extends('layouts.app')

@section('content')
    <div class="w-75 mx-auto" style="margin-top: 100px !important;">
        <h2 class="text-center mt-5">Ehy <u>{{ Auth::user()->username }}</u>!</h2>
    </div>
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-md-4 text-center">
            <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" alt="User avatar"
                style="width:150px; height:150px; border-radius: 50%; object-fit: cover;">
        </div>
        <div class="col-md-4 my-auto profile-data">
            <h5><strong>Your data:</strong></h5>
            <p class="text-right p-0 m-0"><u>Name</u>: {{ Auth::user()->name }}</p>
            <p class="text-right p-0 m-0"><u>Email</u>: {{ Auth::user()->email }}</p>
            <p class="text-right p-0 m-0"><u>Username</u>: {{ Auth::user()->username }}</p>
            <p class="text-right"><u>Registration date</u>: {{ Auth::user()->created_at }}</p>
        </div>
    </div>
    <hr class="mb-5 w-50 mx-auto mt-5">
    <div class="container w-75">
        <h3 class="text-center">Your post on Digibook:</h3>
        <div class="row">
            <div class="alert alert-success mx-auto d-none" id="divMessages" role="alert">
                <h5 id="messages"></h5>
            </div>
        </div>

        {{-- JAVASCRIPT CODE START --}}

        <script>
            let userId = {{ Auth::user()->id }};
            let token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
        </script>

        {{-- END JAVASCRIPT SCRIPT --}}

        <div class="container">
            <div class="row d-flex">
                <div class="col mx-auto">

                    {{-- CRUD Messages --}}
                    @if ($success = session()->get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $success }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container post-profile-mobile">
        <div class="row">
            {{-- Main div --}}
            @foreach (Auth::user()->posts as $post)
                <div class="col-lg-6 my-4" data-id="{{ $post->id }}">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="container d-flex mb-2 justify-content-start ps-0 pe-0">
                                {{-- <div class="d-flex justify-content-around w-100"> --}}
                                <div class="container d-flex mb-2 justify-content-start ps-0">
                                    <div>
                                        <img class="card-img-top border rounded-circle"
                                            style="width: 50px; height: 50px; object-fit: cover;"
                                            src="{{ asset('avatars/' . $post->user->avatar) }}"
                                            alt={{ $post->user->name }}>
                                    </div>
                                    <div class=" d-flex justify-content-start flex-column">
                                        <h3 class="card-title text-start ms-2 mb-0">{{ $post->user->username }}</h3>
                                        <div class="d-flex justify-content-start">
                                        <p class="card-text text-start ms-2 mb-0" style="display:inline-block;">{{ $post->created_at->diffForHumans() }}</p>
                                            @if ($post->updated_at != $post->created_at and $post->updated_at != null)
                                                <small class="card-text ms-2 text-start text-secondary my-auto" style="margin-top:-10px;">(Edited:
                                                    {{ $post->updated_at->diffForHumans() }})</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex">
                                        <a onclick="editApi({{ $post->id }})" class="text-primary mx-2"
                                            style="cursor:pointer;"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a id="delete" onclick='deleteApi({{ $post->id }})' class="text-danger"
                                            style="cursor:pointer;"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="container w-75">
                                <div class="row mb-0">
                                    <div class="alert alert-success mx-auto d-none my-0" id="divMessages-{{ $post->id }}" role="alert">
                                        <h5 id="messages-{{ $post->id }}"></h5>
                                    </div>
                                </div>
                            </div>
                            <form>
                                {{-- <div name="description" class="p-2 w-100 text-start" style="border-radius: 0;" id="description-{{ $post->id }}" > {{ $post->description }} </div> --}}
                                <textarea name="inputDescription" class="p-2 w-100 postTextArea mt-1 text-black" id="inputDescription-{{ $post->id }}" style="border: none; background-color:white; height:100px;" readonly disabled>{{ $post->description }} </textarea>
    
                                        @if ($post->photo != null)
                                <img id="imgNow-{{ $post->id }}" class="card-img mt-1" style="max-width:100%; width:auto; height:auto; max-height:450px; object-fit: cover; "
                                        src="{{ asset('post_images/' . $post->photo) }}" alt="post image">
                                        
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between mt-2">
                                    <span onclick="likes({{ Auth::user()->id }}, {{ $post->id }}, '{{ Auth::user()->username }}')"  style="cursor:pointer;">
                                        @php $check = false; @endphp
                                        <i class="fa 
                                        @foreach ($post->likes as $like)
                                            @if($like->users_id == Auth::user()->id)
                                                @php $check = true; @endphp
                                                fa-heart
                                                @break
                                            @endif
                                        @endforeach
                                        @if (!$check)
                                            fa-heart-o 
                                        @endif
                                        fa-lg text-danger" id="heart_like-{{ $post->id }}" aria-hidden="true"></i>
                                        <span id="likeText-{{ $post->id }}">
                                        @if ($check) Dislike
                                        @else Like
                                        @endif
                                        </span>
                                        </span>
                                        <div>
                                            <small id="youLike-{{ $post->id }}">
                                                @if($post->likes->count() > 0)
                                                    @foreach ( $post->likes as $like )
                                                        @if ($post->likes->count() > 1)
                                                            @if($like->users_username == Auth::user()->username)
                                                                <b>You</b> and 
                                                            @endif
                                                        @else
                                                            @if($like->users_username == Auth::user()->username)
                                                                <b>You</b>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </small>
                                            <small id="othersLike-{{ $post->id }}">
                                                @if ($post->likes->count() > 4)
                                                    @if($like->users_username == Auth::user()->username)
                                                        <a href="#" onclick="sendToModal({{ $post->id }})" data-bs-toggle="modal" data-bs-target="#listLike"><b>{{ $post->likes->count() - 1 }} people</b></a>
                                                    @else
                                                        <a href="#" onclick="sendToModal({{ $post->id }})" data-bs-toggle="modal" data-bs-target="#listLike"><b>{{ $post->likes->count() }} people</b></a>
                                                    @endif
                                                @endif
                                                @if($post->likes->count() >= 1 and $post->likes->count() <= 4)
                                                    @foreach ( $post->likes as $like )
                                                        @if($like->users_username == Auth::user()->username)
                                                        @else <b>{{ $like->users_username }}</b>, 
                                                        @endif
                                                    @endforeach 
                                                @endif
                                            </small>
                                            <small id="finalText-{{ $post->id }}">
                                                @if ($post->likes->count() > 0)like this post!
                                                @endif
                                            </small>
                                        </div>
                                    
                                </div>
                               
                                    {{-- <textarea name="inputDescription" class="p-2 w-100 postTextArea mt-1" id="inputDescription-{{ $post->id }}" style="display:none;">{{ $post->description }} </textarea> --}}
                                <div class="d-flex align-items-end mt-1" data-id="editButtonDiv-{{ $post->id }}"
                                    style="display:none !important;">
                                    <button type="button" data-id="submitButton-{{ $post->id }}"
                                        class="btn btn-primary" onclick="sendUpdateReq({{ $post->id }})">Save changes</button>
                                    <a id="cancel" data-id="cancelButton-{{ $post->id }}" class="ms-2 mb-0"
                                        style="cursor:pointer;" onclick="cancel({{ $post->id }})">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


{{-- Footer --}}
@include('layouts.footer')


    <!-- Modal -->
<div class="modal fade" id="listLike" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Like to the post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table>
                <ul id="usersList">
                    {{-- dinamyc content here --}}
                </ul>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div> 
  </div>
@endsection
