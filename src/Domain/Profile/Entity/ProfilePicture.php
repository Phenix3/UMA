<?php

namespace App\Domain\Profile\Entity;

use App\Domain\Application\Entity\ImageUploadInterface;
use App\Domain\Application\Entity\Traits\FilePropertiesTrait;
use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\TimestampableTrait;
use App\Domain\Auth\Entity\Traits\BlameableTrait;
use App\Domain\Profile\Repository\ProfilePictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProfilePictureRepository::class)]
#[ORM\Table('`profile_profile_pictures`')]
#[Vich\Uploadable]
class ProfilePicture implements ImageUploadInterface
{
    use IdentifiableTrait;
    use BlameableTrait;
    use FilePropertiesTrait;
    use TimestampableTrait;

    #[Vich\UploadableField(
        mapping: 'profile_picture',
        fileNameProperty: 'fileName',
        size: 'size',
        mimeType: 'mimeType',
        originalName: 'originalName',
        dimensions: 'dimensions'
    )]
    #[Assert\Image(
        maxSize: '2M',
        maxSizeMessage: 'profile_picture.file.max_size',
        mimeTypes: ['image/png', 'image/jpeg', 'image/gif'],
        mimeTypesMessage: 'profile_picture.file.mime_types',
        detectCorrupted: true,
        corruptedMessage: 'profile_picture.file.corrupted',
        sizeNotDetectedMessage: 'profile_picture.file.size_not_detected'
    )]
    private ?File $file = null;

    #[ORM\OneToOne(mappedBy: 'picture')]
    private ?Profile $profile = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file = null): static
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }
}
