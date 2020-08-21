<div class="card">

    <div class="card-header d-flex justify-content-between">

        <span class="lead">
            <i class="fas fa-business-time mr-2 text-muted"></i>
            Institution
        </span>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-12">

                <form action="{{ url('settings') . '/store' }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <button class="img-thumbnail" type="button" data-toggle="modal" data-target="#uploadLogo">
                                <img src="{{ url('storage/images') . '/' . $settings->school_logo }}" alt="{{ config('app.name') }}" width="100%">
                            </button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Institution name</label>
                            <input type="text" class="form-control" name="company_name" value="{{ $settings->school_name ?? old('company_name') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Contact phone</label>
                            <input type="tel" class="form-control" placeholder="1 234 567 8901" name="company_phone" value="{{ $settings->phone ?? old('company_phone') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Contact e-mail</label>
                            <input type="email" class="form-control" placeholder="user@company.com" name="company_email" value="{{ $settings->email ?? old('company_email') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address ">Postal Address</label>
                            <input type="text" id="address" class="form-control" name="company_address" value="{{ $settings->address ?? old('company_address') }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

</div>
