# User

**URL:** `/user`

### `/signup` - Creates a new user

Receives:
```json
{
  "username": "apexJCL",
  "first_name": "José Carlos",
  "last_name": "López Gaona",
  "email": "jcl.isc@gmail.com",
  "password": "apex1337@localhost"
}
```
Returns:
```json
{
  "token": "<JWT>"
}
```


### `/login` - Logins a user

Receives:
```json
{
  "username": "apexJCL",
  "password": "root1337"
}
```

Returns:
```json
{
  "token": "<JWT>",
  "first_name": "",
  "last_name": "",
  "username": ""
}
```