## Chat Demo

  Instructions:  

  1.  Run php artisan migrate to create the db schema or run the chat.sql file to have data prepopulated.  

  2.  Run the Laravel app using Valet or run php artisan serve to your localhost.  

  3.  Insert a user in your user table or login using the default user (email: alex@orainteractive.com, psw: secret ).
  All passwords are hashed so if you need to manually add a new user to the db, use Hash::make(), before adding it.  

  4. Besides the /api/auth/login, all the other resorces use JWT for validation, so make sure to send in the header the token received when you first login. It should be something like: Authorization Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJp [...]  

  5.  Start making requests just as specified in http://docs.oracodechallenge.apiary.io, version 5.0.


## Resources

  - **[POST /api/auth/login](http://chat.dev/api/auth/login) **  
  - **[GET /api/auth/logout](http://chat.dev/api/auth/logout) **  
  - **[POST /api/users](http://chat.dev/api/users) **
  - **[GET /api/users/current](http://chat.dev/api/users/current) **
  - **[PATCH /api/users/current](http://chat.dev/api/users/current) **
  - **[GET /api/chats{?page,limit}](http://chat.dev/api/chats?page=1&limit=5) **
  - **[POST /api/chats](http://chat.dev/api/chats) **
  - **[PATCH /api/chats/{id}](http://chat.dev/api/chats/1) **
  - **[GET /api/chats/{id}/chat_messages{?page,limit}](http://chat.dev/api/chats/1/chat_messages?page=1&limit=5) **
  - **[POST /api/chats/{id}/chat_messages](http://chat.dev/api/chats/1/chat_messages) **
