"use client";
import React, { useState, useEffect } from 'react';
import AdminSidebar from '@/components/AdminSidebar';
import { Users as UsersIcon, Loader2, Search, Trash2, Mail } from 'lucide-react';

export default function AdminUsersPage() {
  const [users, setUsers] = useState<any[]>([]);
  const [search, setSearch] = useState('');
  const [loading, setLoading] = useState(true);

  const fetchUsers = async () => {
    try {
      const res = await fetch('/api/admin/users');
      if (res.ok) {
        const data = await res.json();
        setUsers(data);
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchUsers();
  }, []);

  const deleteUser = async (id: number) => {
    if (!window.confirm("Are you sure you want to delete this user? Action cannot be undone.")) return;
    try {
      const res = await fetch(`/api/admin/users/${id}`, { method: 'DELETE' });
      if (res.ok) fetchUsers();
      else alert("Failed to delete user. Please check if they have orders tied to them.");
    } catch (err) {
      console.error(err);
    }
  };

  const filteredUsers = users.filter(u => 
    (u.name && u.name.toLowerCase().includes(search.toLowerCase())) || 
    (u.email && u.email.toLowerCase().includes(search.toLowerCase()))
  );

  return (
    <div className="flex min-h-screen bg-[#FDF8F3]">
      <AdminSidebar />
      <main className="flex-grow md:pl-64 p-4 md:p-8">
        <div className="flex justify-between items-center mb-10">
          <h1 className="text-3xl font-black text-coffee-950">Users Management</h1>
          <div className="relative">
             <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-300" />
             <input 
               type="text" 
               placeholder="Search Name or Email..." 
               value={search}
               onChange={(e) => setSearch(e.target.value)}
               className="bg-white border border-coffee-100 rounded-xl py-3 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#C69276] shadow-sm w-[300px]" 
             />
          </div>
        </div>

        <div className="bg-white rounded-[2.5rem] p-8 border border-coffee-50 shadow-sm overflow-x-auto">
          {loading ? (
             <div className="flex justify-center items-center py-20">
               <Loader2 className="h-10 w-10 text-coffee-300 animate-spin" />
             </div>
          ) : filteredUsers.length === 0 ? (
             <p className="text-center text-coffee-400 py-10 font-bold uppercase tracking-widest text-xs">No users found.</p>
          ) : (
            <table className="w-full text-left min-w-[800px]">
              <thead>
                <tr className="border-b border-coffee-50 text-coffee-300 text-xs font-black uppercase tracking-widest">
                  <th className="pb-4 pt-2">User ID</th>
                  <th className="pb-4 pt-2">Profile</th>
                  <th className="pb-4 pt-2">Role</th>
                  <th className="pb-4 pt-2">Joined Date</th>
                  <th className="pb-4 pt-2 text-center">Actions</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-coffee-50">
                {filteredUsers.map(user => (
                  <tr key={user.id} className="group hover:bg-cream-50/50 transition-colors">
                    <td className="py-5 text-sm font-black text-coffee-950">#UID-{user.id.toString().padStart(4, '0')}</td>
                    <td className="py-5">
                       <div className="flex items-center space-x-4">
                          <div className="w-10 h-10 bg-coffee-100/50 rounded-xl flex items-center justify-center font-black text-coffee-800 uppercase">
                             {user.name ? user.name.charAt(0) : '?'}
                          </div>
                          <div>
                            <p className="font-bold text-coffee-950 text-sm">{user.name}</p>
                            <p className="text-xs text-coffee-400 flex items-center font-medium mt-1">
                               <Mail className="h-3 w-3 mr-1" />
                               {user.email}
                            </p>
                          </div>
                       </div>
                    </td>
                    <td className="py-5">
                       <span className={`px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest inline-flex ${
                         user.role === 'admin' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600'
                       }`}>
                         {user.role}
                       </span>
                    </td>
                    <td className="py-5 text-xs font-bold text-coffee-400">{new Date(user.createdAt).toLocaleDateString()}</td>
                    <td className="py-5 text-center">
                       <div className="flex items-center justify-center space-x-2">
                         {user.role !== 'admin' && (
                            <button 
                              title="Delete User"
                              onClick={() => deleteUser(user.id)} 
                              className="p-2 bg-red-100 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm"
                            >
                              <Trash2 className="h-4 w-4" />
                            </button>
                         )}
                       </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </main>
    </div>
  );
}
