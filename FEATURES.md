# Fyn1x Forum - Features

A modern forum platform with social networking, content management, and community engagement tools. Built with Laravel 13.x and Tailwind CSS v4.

## Tech Stack

- **Backend:** Laravel 13.x (PHP 8.3+)
- **Frontend:** Tailwind CSS v4, Alpine.js, Lucide Icons
- **Database:** MySQL
- **Build:** Vite 8.x
- **Markdown:** Marked.js (client) + Michelf PHP Markdown (server)

---

## Core Forum

### Topics & Discussions
- Create, view, and list topics (admin-only creation)
- Sticky/pinned topics
- Locked topics for moderation
- Published/draft status
- View tracking (once per user)
- Pagination support

### Posts & Replies
- Reply to topics with Markdown support
- Edit posts with edit history tracking
- Delete posts (soft-delete with restoration)
- Hide/unhide posts (moderation)
- Nested comments on posts
- Comment reactions

### Topic Templates
Pre-defined templates with custom fields:
- Dúvida Técnica (Technical Question)
- Showcase (Project Showcase)
- Tutorial
- Bug Report
- Discussão (Discussion)
- Blog Post

Each template supports: text, textarea, select, tags, URL, and image fields.

---

## User System

### Profiles
- Custom usernames, bios, avatars, and banner covers
- Public profile pages at `/profile/{username}`
- Reputation system
- User levels
- Profile view tracking
- Followers/Following lists

### Authentication
- Registration and login
- Role-based access control (admin/user roles)
- Multiple role assignments per user

### User Verification
Automated verification based on activity:
- 20 posts required
- 100 followers required
- 800 reactions received
- Progress tracking with API endpoint

---

## Social Features

### Follow System
- Follow/unfollow users
- Followers and following lists
- Verification affects group verification status

### Reactions
- Toggle reactions on topics, posts, and comments
- Polymorphic reaction system
- Reaction counts for verification requirements

---

## Content Management

### Pages (CMS)
- Admin-creatable static pages
- Slug-based routing (`/p/{slug}`)
- Publish/unpublish capability
- Icon support for navigation
- Ordered sidebar/navigation display

### Blog System
- Users can enable/disable personal blogs
- Create, edit, delete blog posts
- Template-based blog posts
- Summary/excerpt support
- Published/draft status
- Slug-based URLs

### Tags & Taxonomy
- Taggable topics and posts
- Many-to-many tag relationships

---

## Groups & Communities

### Group Management
- Create public or private groups
- Join/leave groups
- Pending approval for private groups
- Group creators have special privileges
- Verified groups (auto-verified when verified user joins)

### Group Roles
- Custom roles per group with hierarchy (level 0-100)
- Granular permissions:
  - `can_manage` - Full management
  - `can_kick` - Remove members
  - `can_edit` - Edit group content
  - `can_delete` - Delete content
  - `can_moderate` - Moderation tools
- Color-coded roles with icons

### Group Topics & Messages
- Create topics within groups
- Group-specific discussions
- Real-time messaging API endpoints
- Message deletion

---

## Media & Galleries

### Image Gallery
- User galleries with folders
- Public/private folders
- Image upload with automatic WebP conversion
- Folder management (create/delete)
- API endpoints for image retrieval

### Image Management
- Polymorphic image relationships (users, topics, posts, folders)
- Avatar handling
- Multiple images per entity
- Intervention Image integration

---

## Admin Panel (`/admin`)

### User Management
- Ban/unban users
- Role assignment
- View user details

### Content Management
- Publish/unpublish topics
- Delete topics and posts
- Hide/unhide posts
- Page CRUD (create, read, update, delete)
- Image moderation

### System Management
- Role management (create, toggle active, delete)
- Archive management (polymorphic archiving)
- View all users, topics, posts, and images

---

## Search

- Search topics, posts, and users
- Minimum 2-character query
- Dedicated search results page
- JSON API response option

---

## Archive System

- Polymorphic archiving for users, topics, and posts
- File attachment support
- Admin-managed archives

---

## UI/UX Features

- **Dark theme** with slate-950 background
- **Glass-morphism** design with backdrop blur effects
- **Gradient accents** (blue to emerald)
- **Responsive design** with Alpine.js interactivity
- **Lucide Icons** throughout the interface
- **Markdown rendering** in posts and topics
- **Breadcrumb navigation**
- **Alert/notification system**

---

## Database Models

| Model | Key Features |
|-------|--------------|
| User | Auth, profiles, roles, follow system, verification |
| Topic | Forum topics, sticky/locked, published status, templates |
| Post | Replies, markdown, edit tracking |
| Comment | Nested comments, reactions, soft-delete |
| Reaction | Polymorphic likes/reactions |
| Group | Communities, private/public, verification |
| GroupMember | Membership with status (pending/approved/banned) |
| GroupRole | Custom roles with permissions |
| GroupMessage | Group chat messages |
| BlogPost | User blog posts with templates |
| UserBlog | Blog enable/disable per user |
| Pages | CMS pages with ordering |
| Image | Polymorphic images |
| GalleryFolder | Image organization |
| Role | Global user roles |
| Tag / Taggable | Taxonomy system |
| Follow | User follow system |
| Archive | Polymorphic archiving |
| TopicViews / ProfileViews | View tracking |
| UserVerification | Verification status & progress |

---

## Key Technical Features

- **UUID Primary Keys** - All major models use UUIDs
- **Soft Deletes** - Topics, posts, and comments support soft deletion
- **Polymorphic Relationships** - Images, reactions, archives, and tags work across multiple models
- **Moderation System** - Edit history, hidden posts, moderation reasons
- **View Tracking** - Topic and profile views tracked once per user
- **Slug Generation** - Automatic URL slugs via `spatie/laravel-sluggable`
