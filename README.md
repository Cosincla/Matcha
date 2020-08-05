# Matcha

Matcha is a project I worked on during my time at WeThinkCode. The project entailed developing a dating website that can take a user's Romantic/Sexual preferences, Interests, and their location to pair users together based on that information. Users are able to like each other, if two users like each other then they would be able to chat with one another. If they annoy each other then they can be blocked.

## Requirements
* [Xamp]
* [Thunderbird]

## Installation

1. Download and install requirements.
2. Follow [these] instructions, excluding the testmail.php part at the end.
3. In the XAMP Control Panel, start Apache, MySql and Mercury.
4. Navigate to http://localhost/Matcha/index.php

## Usage/Tests

1. Navigate to http://localhost/Camagru/index.php
2. Under New User, click on the link and sign up (Use local-user@localhost.com as your email).
3. After a few minutes, you should receive an email in thunderbird, use the verification code on the verification page (If you dont feel like waiting look it up in phpmyadmin cosincla_camagru -> verification under unlock).
4. Sign in with your account details.
5. Click on Settings and choose the Edit Profile Photo option. Choose a file, upload then save it.
6. Click on Settings and choose the My Profile option. There you must edit your biography, add a cover photo and add between 1 and 5 photos of yourself. This is required to use the matching feature.
7. Click on Settings and choose the Interests option. There you must choose four things that you are interested in. This is required to use the matching feature.
8. Open Matcha again in an incognito window, make another profile under local-owner@localhost.com and repeat steps 3 to 7. (make sure the interests are simular if not the same)
9. Each profile should show up in the other's users page, click view profile then click like.
10. Click on Settings and choose the chat settings option. Click on the send user a message option.
11. Do the same on the other profile.
12. Click on the field at the bottom of the box then type a message. The other user should have a message.
13. On the Users page, view the profile and click block. They should now be removed from the Users page.
14. Click on Settings and choose the Block options button. You can choose to unblock the profile and return them to the Users page.
15. If there are multiple profiles, you can choose to filter them with the Filter options in the settings. There, you can choose the age, fame, distance and minimum number of shared interests, then order them by which of those fouur is the most important.

If all that was successful, then all the important stuff works.

(Note: Location settings no longer works as I refuse to pay for a subscription that I will only use once. If you have an active key for the google maps api, you can put it into loc.php line 12 in '&key=...') 

## Database Structure
(Note: for all tinyints, 1 is true and 0 is false)

### users

* `int` *id* (Primary key)
* `varchar(191)` *name*
* `varchar(191)` *surname*
* `varchar(20)` *username* (unique)
* `int` *age*
* `varchar(191)` *gender*
* `varchar(191)` *preference*
* `char(128)` *password* (hashed so nobody can steal it)
* `varchar(191)` *email*
* `tinyint(1)` *validated* (Has the user been successfully verified?)
* `tinyint(1)` *interests* (Did they fill this bit in?)
* `int` *pictures*

### interests

* `varchar(20)` *user_id*
* `varchar(191)` *interest_1*
* `varchar(191)` *interest_2*
* `varchar(191)` *interest_3*
* `varchar(191)` *interest_4*

### profile_photos

* `int` *id* (Primary key)
* `varchar(20)` *user_id*
* `tinyint(1)` *selected* (Is this photo currently in use?)

### uploads

* `int` *id* (Primary key)
* `varchar(20)` *image_creator*
* `varchar(191)` *image_id*

### likes

* `varchar(191)` *liked_id* (id of whomever got a like from another user)
* `varchar(191)` *liker_id* (id of whomever liked another user)
* `tinyint(1)` *like*

### blocks

* `varchar(191)` *blocked_id* (id of whomever got blocked by another user)
* `varchar(191)` *blocker_id* (id of whomever blocked another user)
* `tinyint(1)` *block*

### ratings

* `varchar(191)` *rated_id* (id of whomever got rated by another user)
* `varchar(191)` *rater_id* (id of whomever rated another user)
* `int` *rating*

### location

* `varchar(191)` *user_id*
* `decimal(6, 3)` *latitude*
* `decimal(6, 3)` *longitude*
* `varchar(191)` *city*
* `varchar(191)` *region*
* `varchar(191)` *code*
* `tinyint(1)` *tracker*

### comments

* `int` *id* (Primary key)
* `varchar(191)` *image_id*
* `varchar(20)` *image_creator*
* `varchar(200)` *comment*
* `varchar(20)` *commenter*

### verification
(Note: User information in this table is deleted once the user is successfully verified)

* `int` *id* (Primary key)
* `varchar(191)` *user_id*
* `varchar(20)` *unlock* (verification code needed to validate a user's profile)

### matches

* `int` *matches*
* `varchar(191)` *user_1*
* `varchar(191)` *user_2*

### messages

* `varchar(191)` *sender*
* `varchar(191)` *receiver*
* `varchar(191)` *message*
* `timestamp` *date_created*

### profiles

* `varchar(191)` *username*
* `varchar(255)` *bio*
* `varchar(191)` *cover_image*
* `tinyint(1)` *bio_check*
* `tinyint(1)` *cover_check*
* `tinyint(1)` *images_check*

### filters

* `varchar(255)` *username*
* `varchar(255)` *age*
* `varchar(255)` *fame*
* `varchar(255)` *distance*
* `varchar(255)` *interests*
* `varchar(255)` *order*

### visits

* `varchar(255)` *visited*
* `varchar(255)` *visitor*
* `int` *visits*

### distance

* `varchar(255)` *user_1*
* `varchar(255)` *user_2*
* `int` *distance*

### fame

* `varchar(255)` *username*
* `int` *average*


## File Structure

* `blocks:` contains files for blocking/unblocking other users.
* `chat:` contains files required to use the chat feature.
* `chat_select:` contains files for selecting available chats.
* `config:` contains files for setting up the database.
* `distance:` contains files for calculating distance between users.
* `email_e:` contains files for changing email addresses.
* `email_r:` contains files for recovering emails.
* `email_v:` contains files for verifying emails.
* `filter:` contains files required for the filter.
* `filtered:` contains files required to show filtered results.
* `interest:` contains files for saving the user's interests.
* `landing_page:` contains files for the landing page.
* `location:` contains files for saving/tracking the user's adresss.
* `match:` contains files for matching user's interests.
* `myprofile:` contains files for the user's profile.
* `new_user:` contains files for creating a new user.
* `pphoto:` contains files for editing profile photos.
* `pswd:` contains files for changing your password.
* `rating:` contains files for rating other users and seeing the user's average rating.
* `user_e:` contains files for changing your username.
* `users:` contains files for commenting and logging out.
* `viewbio:` contains files for viewing another user's bio.
* `viewlikes:` contains files for viewing who likes the user.
* `visits:` contains files for calculating the total number of people who visited your profile.
* `author:` author file.
* `index.php:` php file that starts up the website.
* `init.php:` php file that starts the session.

[xamp]: https://www.apachefriends.org/index.html
[thunderbird]: https://www.thunderbird.net/en-ZA/
[these]: http://wiki.deglowdesign.de/xampp:set-up-mercury-for-email-debugging-with-php-sendmail
