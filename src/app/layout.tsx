"use client";
import { Outfit } from "next/font/google";
import "./globals.css";
import CustomerSidebar from "@/components/CustomerSidebar";
import { CartProvider } from "@/lib/CartContext";
import { usePathname } from "next/navigation";

const outfit = Outfit({ subsets: ["latin"] });

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const pathname = usePathname();
  
  // ITATAGO NATIN ANG SIDEBAR SA MGA PAGES NA ITO:
  const isAuthPage = pathname === '/' || pathname === '/login' || pathname === '/register';
  const isAdminPath = pathname.startsWith('/admin');

  return (
    <html lang="en">
      <body className={`${outfit.className} bg-cream-50 text-coffee-950`}>
        <CartProvider>
          <div className="flex">
            {/* Sidebar logic: Wag ipakita kung Login o Register Page */}
            {!isAuthPage && !isAdminPath && <CustomerSidebar />}
            
            <main className={`flex-grow min-h-screen ${(!isAuthPage && !isAdminPath) ? 'pl-72' : ''}`}>
              {/* Para sa Auth pages, wala tayong padding. Para sa iba, meron. */}
              <div className={`${!isAuthPage ? 'p-8 lg:p-12' : ''}`}>
                {children}
              </div>
            </main>
          </div>
        </CartProvider>
      </body>
    </html>
  );
}
