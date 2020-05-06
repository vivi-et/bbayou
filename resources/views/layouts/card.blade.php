
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    @if($giftcon->cover_image == "noimage.jpg")
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                        xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false"
                        role="img" aria-label="Placeholder: Thumbnail">

                        <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef"
                            dy=".3em">No Image</text>
                    </svg>
                    @else

                    {{ $giftcon->imagepath }}

                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                        src="/storage/giftcon_images/{{ $giftcon->imagepath }}">
                    @endif
                    <div class="card-body">
                        <p class="card-text">
                            <a href="/giftcon/{{$giftcon->id}}">
                                {{$giftcon->title}}
                            </a>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                            </div>
                            <small class="text-muted">{{ $giftcon->user->name }}</small>
                            <small class="text-muted"> {{ $giftcon -> created_at->toFormattedDateString() }} </small>
                        </div>
                    </div>
                </div>
            </div>




