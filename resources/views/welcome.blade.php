<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- <script src="{{ asset('js/app.js') }}" ></script> -->

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
          <div id="app">
            <!-- <example-component></example-component> -->
            <div class="container chats">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card card-default">
                            <div class="card-header">Chats</div>

                            <div class="card-body">
                             <chat-message :messages="messages"></chat-message>
                            </div>
                            <div class="card-footer">
                                <chat-form
                                        @messagesent="addMessage"
                                ></chat-form>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="user in users">
                                @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                            </li>
                        </ul>
                    </div> -->
                    <!-- :user="{{ auth()->user() }}" -->
                </div>
            </div>
         </div>
         <script src="/js/app.js" charset="utf-8"></script>
    </body>
</html>
