
0. [rule] **file-consistency**
    - images: max:2048 mimes:jpeg,png,webp,jpg
    - password: min:8
    - email: unique

0. [rule] **return-consistency**
    - message: string // if success is false, message is error message(s)
    - data: object

0. [get] */search/{search}* : **search news and loker (getcount)**
    params: {
        <!-- no params -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            news: number,
            loker: number,
        }
    }

0. [get] */user* : **show user profile**
    params: {
        <!-- no params -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data user
            alumni: {
                ... // data alumni
            }
        }
    }
1. [post] */user/update*: **update user account**
    params: {
        <!-- form is dynamic, kirim yang mau diubah saja -->
        email: string,
        old_password: string,
        password: string,
        password_confirmation: string,
        avatar: file,
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data user
        }
    }
    note:
    - kalau mau update password: perlu old_password, password, password_confirmation
    - selain itu nda perlu
    - pakai post karena ada file upload (perluki multipart/form-data kekna kalau put)
    - ubah password nda akan reset token
2. [post] */user/ban*: **ban user**
    params: {
        id_user: number,
        ban_reason: string,
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data user
        }
    }
3. [post] */user/unban*: **unban user**
    params: {
        id_user: number,
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data user
        }
    }

0. [post] */auth/login*: **login**
    params: {
        email: string,
        password: string,
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data user

        }
    }
1. [post] */auth/register*: **register**
    params: {
        email: string,
        password: string,
        password_confirmation: string,
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data user
        }
    }
2. [post] */auth/logout*: **logout**
    params: {
        <!-- no params -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data user
        }
    }

0. [get] */berita*: **show all news (search)**
    params: {
        search: string,
        page: number = 1,
        limit: number = 10, // per page
        id_kategori_berita: number
    }
    response: {
        success: boolean,
        message: string,
        data: {
            current_page: number,
            ... // isi berita
            is_liked: boolean, // jika user sudah like berita ini
            kategori: {
                ... // data kategori berita
            }
        },
        ... // data lain (page_url, next_page_url, prev_page_url, total, dll)
    }
1. [get] */berita/id/{id}*: **show news by id**
    params: {
        <!-- no params, di url ji -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data berita
            is_liked: boolean, // jika user sudah like berita ini
            kategori: {
                ... // data kategori berita
            }
        },
    }
2. [get] */berita/kategori/{id}*: **show news by category**
    params: {
        <!-- no params, di url ji -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data berita
        },
    }
3. [post] */berita/like*: **like news**
    params: {
        id_berita: number
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data berita
            is_liked: boolean, // jika user sudah like berita ini
        },
    }

0. [get] */event*: **show all events**
    params: {
        <!-- no params -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data events
        },
    }
1. [get] */event/id/{id}*: **show event by id**
    params: {
        <!-- no params, di url ji -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data event,
            is_registered: boolean, // jika user sudah register ke event ini
        },
    }
2. [post] */event/register*: **register to event**
    params: {
        id_event: number
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data event
        },
    }
3. [post] */event/unregister*: **unregister from event**
    params: {
        id_event: number
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data event
        },
    }

0. [get] */loker*: **show all job vacancies (search)**
    params: {
        search: string, //will search in job title and company name
        page: number = 1,
        limit: number = 10, // per page
    }
    response: {
        success: boolean,
        message: string,
        data: {
            current_page: number,
            ... // isi job vacancies
            perusahaan: {
                ... // data perusahaan (logo, nama, dll)
            }
        },
        ... // data lain (page_url, next_page_url, prev_page_url, total, dll)
    }
1. [get] */loker/id/{id}*: **show job vacancy by id**
    params: {
        <!-- no params, di url ji -->
    }
    response: {
        success: boolean,
        message: string,
        data: {
            ... // data job vacancy
            perusahaan: {
                ... // data perusahaan (logo, nama, dll)
            }
        },
    }


<!-- ini mau pilih yang mana? kalau pakai slug, apinya kutukar, yg id jadinya /id/{id} -->
get /berita/{id}: show news by id,
get /berita/slug/{slug}: like news by id,
<!-- berita post dan put untuk admin interface ji -->



<!-- anything below is for api body request, im typing here because i need github copilot -->

login
{
    "email": "admin@gmail.com",
    "password": "admin123"
}
