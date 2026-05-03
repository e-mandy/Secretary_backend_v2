<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlacklistedAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlacklistedAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlacklistedAccessToken query()
 */
	class BlacklistedAccessToken extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $label
 * @property string $type_doc
 * @property string $file_mime_type
 * @property int $file_size
 * @property string $file_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $professor_id
 * @property-read mixed $file_url
 * @property-read \App\Models\Professor $professor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereFileMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereProfessorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereTypeDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUpdatedAt($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Professor> $professors
 * @property-read int|null $professors_count
 * @method static \Database\Factories\MatterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matter whereUpdatedAt($value)
 */
	class Matter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property string $lastname
 * @property string $firstname
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Matter> $matters
 * @property-read int|null $matters_count
 * @method static \Database\Factories\ProfessorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Professor whereUpdatedAt($value)
 */
	class Professor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $token
 * @property string|null $revoked_at
 * @property string $expires_at
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken whereRevokedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefreshToken whereUserId($value)
 */
	class RefreshToken extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $lastname
 * @property string $firstname
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RefreshToken> $refresh_tokens
 * @property-read int|null $refresh_tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

