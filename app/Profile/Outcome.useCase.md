# `outcome` Use Cases

## Scenarios Mapping Per Actor/Uri

| Actor \ Uri> | outcome/   | outcome/uid | outcome/uid/pokename |
|:-------------|:-----------|:------------|:---------------------|
| fb           | Authorize  | n/a         | n/a                  |
| guest        | Invitation | InvitationX | Redirect             |
| uid owner    | Redirect   | Build-Show  | Rebuild-Show         |
| !uid owner   | Invitation | InvitationX | Redirect             |

## Scenarios
### Authorize
 + Put user on record if not yet
 + Redirect to `outcome/uid`
### Redirect
 + Redirect to `outcome/uid`
### Invitation
 + og = impersonal og image (`what-pokemon-are-you.jpg`)
 + show splash image (`welcome.jpg`) with login button
### InvitationX
 + og = individual profile image
 + show splash image (`welcome.jpg`) with login button
### Build/Show
 + If no individual profile image then build one
 + og = individual profile image
 + show individual profile image
 + show alternatives leading to `outcome\uid\pokename`
### Rebuild/Show
 + Build individual profile image using `pokename`
 + og = individual profile image
 + show individual profile image
 + show alternatives leading to `outcome\uid\pokename`

## Scripts
### app/Profile/Outcome.preHTML.php
```
switch (user)
  case guest:
        if (referer==fb) {
          if (!exists(fbUserId))
            createUser(fbUser)
          currentUser=getUser(fbUserId)
          redirect(outcome/ + currentUser.uid)
        }
        break
  case registered:
        if (!url(uid))
            redirect(outcome/ + currentUser.uid)
          else {
            if (url(uid)==currentUser.uid) {
              if (!exists(profileImage) || url(pokename))
                pokename=url(pokename)|selectRandomPokename()
                createProfileImage(pokename)
              if (url(pokename))
                redirect(outcome/ + currentUser.uid)
            }
          }
        break
```
### app/Facebook/fb.meta.php
```
$fbmeta = &$fbmetacollection['public']
if (MODULE::currMod=='outcome' && url(uid) && userExists(url(uid)))
  $fbmeta = &$fbmetacollection['outcome']
```
### app/Profile/Outcome.view.php
```
if (url(uid) && url(uid)==currentUser.uid) {
  showProfileImage()
  showAlternatives()
} else {
  showWelcome()
}
```
