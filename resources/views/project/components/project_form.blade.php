



                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $project->name or "" }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $project->email or "" }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="desc" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    {{--  <input id="desc" type="number" class="form-control{{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc" value="{{ $project->desc or "" }}" required>  --}}
                                    <textarea id="desc" rows="10" cols="30" class="form-control{{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc" >{{ $project->desc or "" }}</textarea>
                                    @if ($errors->has('desc'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('desc') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="project_file" class="col-md-4 col-form-label text-md-right">{{ __('project_file') }}</label>

                                <div class="col-md-6">
                                    <input id="project_file" type="file" class="form-control" name="project_file">

                                    @if ($errors->has('project_file'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('project_file') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            

