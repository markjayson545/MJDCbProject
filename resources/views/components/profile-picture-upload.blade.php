@props([
    'profilePicturePath' => null,
    'initials' => 'NA',
    'displayName' => '',
    'uploadRoute',
    'inputId' => 'profilePictureInput',
    'containerId' => 'profilePictureContainer',
    'imageId' => 'profileImage',
    'initialsId' => 'profileInitials',
    'statusId' => 'profilePictureUploadStatus',
])

<div style="text-align: center;">
    <div style="position: relative; display: inline-block;">
        <input type="file" id="{{ $inputId }}" accept="image/*" style="display: none;">

        <button
            type="button"
            id="{{ $containerId }}"
            style="background: transparent; border: 0; cursor: pointer; position: relative; display: inline-block; padding: 0; transition: opacity 0.2s ease;"
            onmouseover="this.style.opacity='0.8'"
            onmouseout="this.style.opacity='1'"
            onclick="document.getElementById('{{ $inputId }}').click()"
        >
            @if(! empty($profilePicturePath))
                <img
                    id="{{ $imageId }}"
                    src="{{ asset('storage/'.$profilePicturePath) }}"
                    alt="Profile Picture"
                    class="student-avatar"
                    style="object-fit: cover; transition: opacity 0.2s ease;"
                >
            @else
                <span id="{{ $initialsId }}" class="student-avatar" style="transition: opacity 0.2s ease;">
                    {{ $initials }}
                </span>
            @endif

            <span style="position: absolute; bottom: 0; right: 0; background: rgba(34, 197, 94, 0.92); border-radius: 9999px; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #ffffff; font-weight: 700; font-size: 1.25rem; line-height: 1;">
                +
            </span>
        </button>

        <div id="{{ $statusId }}" style="margin-top: 1rem; display: none;"></div>
    </div>

    <h4 style="margin: 1rem 0 0.5rem; color: var(--clr-text); font-family: 'Fira Code', monospace;">
        {{ $displayName }}
    </h4>
    <p style="margin: 0; color: var(--clr-text-muted); font-size: 0.86rem;">Click profile picture to upload</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById(@js($inputId));
    const status = document.getElementById(@js($statusId));
    const container = document.getElementById(@js($containerId));
    const imageId = @js($imageId);
    const initialsId = @js($initialsId);
    const uploadUrl = @js($uploadRoute);

    if (!input || !status || !container) {
        return;
    }

    const showStatus = function (message, color) {
        status.style.display = 'block';
        status.innerHTML = '<div style="color: ' + color + '; font-size: 0.9rem;">' + message + '</div>';
    };

    const hideStatusSoon = function () {
        setTimeout(function () {
            status.style.display = 'none';
        }, 3000);
    };

    input.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (!file) {
            return;
        }

        showStatus('Uploading...', '#86efac');

        const formData = new FormData();
        formData.append('profile_picture', file);

        fetch(uploadUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData,
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) {
                        const validationMessage = data.errors && data.errors.profile_picture
                            ? data.errors.profile_picture[0]
                            : data.message;

                        throw new Error(validationMessage || 'Upload failed. Please try again.');
                    }

                    return data;
                });
            })
            .then(function (data) {
                let profileImage = document.getElementById(imageId);

                if (profileImage) {
                    profileImage.src = data.profile_picture_url + '?t=' + new Date().getTime();
                } else {
                    const initials = document.getElementById(initialsId);

                    if (initials) {
                        initials.style.display = 'none';
                    }

                    profileImage = document.createElement('img');
                    profileImage.id = imageId;
                    profileImage.src = data.profile_picture_url;
                    profileImage.alt = 'Profile Picture';
                    profileImage.className = 'student-avatar';
                    profileImage.style.objectFit = 'cover';
                    profileImage.style.transition = 'opacity 0.2s ease';
                    container.insertBefore(profileImage, container.querySelector('span:last-child'));
                }

                showStatus('Profile picture updated.', '#86efac');
                hideStatusSoon();
            })
            .catch(function (error) {
                showStatus('Error: ' + error.message, '#fda4af');
                hideStatusSoon();
            });

        input.value = '';
    });
});
</script>
