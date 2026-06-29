<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // buat admin
        // password admin (passwordnya 123)
        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'admin',
            'akses' => 1
        ]);

        // buat auditi
        // passwordnya 123
        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'auditi',
            'email' => 'auditi@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditi',
            'id_prodi' => 1,
        ]);

        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'auditi1',
            'email' => 'auditi1@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditi',
            'id_prodi' => 2,
        ]);

        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'auditi2',
            'email' => 'auditi2@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditi',
            'id_prodi' => 3,
        ]);
        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'auditi3',
            'email' => 'auditi3@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditi',
            'id_prodi' => 8,
        ]);
        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'auditi4',
            'email' => 'auditi4@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditi',
            'id_prodi' => 10,
        ]);
        

        // buat auditor
        // passwordnya 123
        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'NOLA RITHA, S.T., M.CS',
            'email' => 'auditor@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditor'
        ]);

        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'Teddy Haryadi, SE., M.Ak',
            'email' => 'auditor2@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditor'
        ]);

        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'Yudi Umara, M.Pd',
            'email' => 'auditor3@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'auditor'
        ]);

        // buat pimpinan
        // passwordnya 123
        $this->db->table('users')->insert([
            'uuid' => service('uuid')->uuid4()->toString(),
            'name' => 'pimpinan',
            'email' => 'pimpinan@gmail.com',
            'password' => password_hash('123', PASSWORD_BCRYPT),
            'role' => 'pimpinan'
        ]);
        
    }
}
