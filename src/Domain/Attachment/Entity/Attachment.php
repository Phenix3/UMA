<?php

namespace App\Domain\Attachment\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Attachment\Repository\AttachmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 */
#[ORM\Entity(repositoryClass: AttachmentRepository::class)]
#[ORM\Table('`attachment_attachments`')]
#[Vich\Uploadable()]
class Attachment implements \Stringable
{
    use IdentifiableTrait;

    #[ORM\Column(length: 255)]
    private ?string $fileName = '';

    /**
     * @Vich\UploadableField(mapping="attachments", fileNameProperty="fileName", size="fileSize")
     */
    #[Vich\UploadableField(mapping: 'attachments', fileNameProperty: 'fileName', size: 'fileSize')]
    private ?File $file = null;

    #[ORM\Column(options: ['unsigned' => true])]
    private int $fileSize = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $createdAt;

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName ?: '';

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): Attachment
    {
        $this->file = $file;

        return $this;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): Attachment
    {
        $this->fileSize = $fileSize ?: 0;

        return $this;
    }

    public function __toString(): string
    {
        return $this->fileName;
    }
}
