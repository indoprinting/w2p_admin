<!-- Modal -->
<div class="modal fade" id="responReview{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="responReviewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.response') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $review->id }}">
                    <div class="row">
                        <label class="col-sm-3">Respon</label>
                        <div class="col-sm-9">
                            <x-textarea name="respon" rows="5">
                                {{ $review->respon }}
                            </x-textarea>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
